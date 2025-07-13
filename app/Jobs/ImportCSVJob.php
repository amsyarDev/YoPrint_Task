<?php

namespace App\Jobs;

use App\Events\FileImportUpdated;
use App\Models\FileImport;
use App\Models\Product; // Add this import
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ImportCSVJob implements ShouldQueue
{
    use Queueable;

    public $path;
    public $fileImportId;

    /**
     * Create a new job instance.
     */
    public function __construct($path, $fileImportId = null)
    {
        $this->path = $path;
        $this->fileImportId = $fileImportId;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileImport = FileImport::find($this->fileImportId);
        $fileImport->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);
        FileImportUpdated::dispatch($fileImport);

        try {
            $fullPath = Storage::path($this->path);

            $chunkSize = 1000; // Adjust chunk size as needed
            $file = fopen($fullPath, 'r');
            $header = fgetcsv($file);

            $rows = [];
            while (($row = fgetcsv($file)) !== false) {
                $rows[] = array_combine($header, $row);

                if (count($rows) >= $chunkSize) {
                    $this->processChunk($rows);
                    $rows = [];
                }
            }
            // Process any remaining rows
            if (!empty($rows)) {
                $this->processChunk($rows);
            }

            fclose($file);
            // Optionally delete the file after processing
            Storage::delete($this->path);

            $fileImport->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
            FileImportUpdated::dispatch($fileImport);
        } catch (\Throwable $e) {
            $fileImport->update(['status' => 'failed']);
            FileImportUpdated::dispatch($fileImport);
            throw $e;
        }
    }

    protected function processChunk(array $rows)
    {
        foreach ($rows as $data) {
            if (!empty($data['PRODUCT_TITLE'])) {
                Product::create(['title' => $data['PRODUCT_TITLE']]);
            }
        }
    }
}

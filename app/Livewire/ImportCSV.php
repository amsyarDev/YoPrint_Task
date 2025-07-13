<?php

namespace App\Livewire;

use App\Events\FileImportUpdated;
use App\Jobs\ImportCSVJob;
use App\Models\FileImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ImportCSV extends Component
{
    use WithFileUploads;

    public $csv; // Changed from $uploadedFile to $csv

    public function rules()
    {
        return [
            'csv' => 'required|file|mimes:csv,txt,text/csv|max:102400', // 100MB
        ];
    }

    public function render()
    {
        return view('livewire.import-c-s-v');
    }

    public function import()
    {
        $this->validate();
        // Store the uploaded file and get its path
        $fileImport = FileImport::create([
            'file_name' => $this->csv->getClientOriginalName(),
            'status' => 'pending',
            'started_at' => now(),
        ]);
        FileImportUpdated::dispatch($fileImport);

        $path = $this->csv->store('csv_uploads');
        ImportCSVJob::dispatch($path, $fileImport->id);
        $this->csv = null;
        $this->dispatch('toast', message: 'This csv import has been add to queue!', type: 'success');
    }

    public function clearCsv($toast = true)
    {
        if ($this->csv) {
            // Delete the stored file using its path
            Storage::delete($this->csv?->getStoredPath() ?? $this->csv?->getClientOriginalName());
        }
        $this->csv = null;

        if ($toast) {
            $this->dispatch('toast', message: 'File cleared!', type: 'success');
        }
    }
}

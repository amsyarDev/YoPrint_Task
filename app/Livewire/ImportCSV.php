<?php

namespace App\Livewire;

use App\Jobs\ImportCSVJob;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ImportCSV extends Component
{
    use WithFileUploads;

    public $csv; // <-- Change from $csvFile to $csv

    public function render()
    {
        return view('livewire.import-c-s-v');
    }

    public function import()
    {
        $this->dispatch('toast', message: 'Importing csv...', type: 'info');

        // $this->validate([
        //     'csv' => 'required|file|mimes:csv,txt',
        // ]);

        // $path = $this->csv->store('csv_uploads');

        // // Open the file and dispatch jobs per row
        // $fullPath = Storage::path($path);
        // $file = fopen($fullPath, 'r');

        // $header = fgetcsv($file); // read header row

        // while (($row = fgetcsv($file)) !== false) {
        //     $data = array_combine($header, $row);
        //     ImportCSVJob::dispatch($data);
        // }

        // fclose($file);

        $this->dispatch('toast', message: 'CSV imported!', type: 'info');
    }
}

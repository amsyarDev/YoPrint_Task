<?php

namespace App\Livewire;

use App\Models\FileImport;
use Livewire\Component;

class FileImportTable extends Component
{
    public $fileImports;

    public function mount()
    {
        $this->loadImports();
    }

    public function loadImports()
    {
        $this->fileImports = FileImport::latest()->take(10)->get();
    }

    protected $listeners = ['refreshImports' => 'loadImports'];

    public function render()
    {
        return view('livewire.file-import-table');
    }
}

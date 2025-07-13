<div class="p-6 max-w-4xl mx-auto">
    <form wire:submit.prevent="import" class="space-y-4">
        @error('csv')
            <div class="text-red-500 mt-2">{{ $message }}</div>
        @enderror
        <div x-data
            x-on:drop.prevent="
        $refs.fileInput.files = event.dataTransfer.files;
        $refs.fileInput.dispatchEvent(new Event('change'));
    "
            x-on:dragover.prevent
            class="w-full border-dashed rounded p-10 text-center cursor-pointer
        border-4
        @if ($csv && $this->csv?->getClientOriginalExtension() == 'csv') border-green-500 bg-green-50
        @elseif ($csv) border-red-500 bg-red-50
        @else
            border-gray-300 @endif">
            <input type="file" wire:model="csv" class="hidden" id="fileInput" x-ref="fileInput">
            <label for="fileInput">
                <p class="text-gray-700" wire:loading="">Loading...</p>
                <p class="text-gray-700" wire:loading.remove="">{{ $csv?->getClientOriginalName() ?? 'Select file or Drag and Drop' }}</p>
            </label>
        </div>
        @if ($csv != null)
            <div class="mt-4 flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Import CSV
                </button>
                <button type="button" wire:click="clearCsv"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Clear
                </button>
            </div>
        @endif
    </form>
</div>

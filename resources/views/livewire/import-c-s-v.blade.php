<div class="p-6 max-w-4xl mx-auto">
     <form>
        <div
            x-data="{ isDropping: false }"
            x-on:dragover.prevent="isDropping = true"
            x-on:dragleave.prevent="isDropping = false"
            x-on:drop.prevent="isDropping = false"
            class="w-full border-dashed border-4 border-gray-300 rounded p-10 text-center cursor-pointer"
            :class="{ 'border-blue-500 bg-blue-50': isDropping }"
        >
            <input type="file" wire:model="csv" wire:change="import" class="hidden" id="fileInput">
            <label for="fileInput">
                <p class="text-gray-700">Select file or Drag and Drop</p>
            </label>
        </div>
    </form>
</div>

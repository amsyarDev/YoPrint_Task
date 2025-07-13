<div x-data
     x-init="
        Echo.channel('file-imports')
            .listen('FileImportUpdated', (e) => {
                Livewire.emit('refreshImports');
            });
     ">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Status</th>
                <th>Completed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fileImports as $import)
                <tr>
                    <td>{{ $import->file_name }}</td>
                    <td>{{ ucfirst($import->status) }}</td>
                    <td>{{ $import->completed_at ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

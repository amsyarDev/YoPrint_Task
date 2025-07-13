<?php

namespace App\Events;

use App\Models\FileImport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileImportUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public FileImport $fileImport;

    /**
     * Create a new event instance.
     */
    public function __construct(FileImport $fileImport)
    {
        $this->fileImport = $fileImport;
    }

    /**
     * Get the channel the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('file-imports');
    }

    /**
     * Data sent to the frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->fileImport->id,
            'file_name' => $this->fileImport->file_name,
            'status' => $this->fileImport->status,
            'completed_at' => optional($this->fileImport->completed_at)->toDateTimeString(),
        ];
    }

    /**
     * Optional: Customize the event name
     */
    public function broadcastAs(): string
    {
        return 'FileImportUpdated';
    }
}

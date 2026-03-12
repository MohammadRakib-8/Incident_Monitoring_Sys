<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncidentModified implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('incidents'),
        ];
    }

       public function broadcastAs(): string
    {
        return 'incident-modified';
    }

    //  public function broadcastWith(): array
    // {
    //     return [
    //         'id' => $this->incident->id,
    //         'status' => $this->incident->status,
    //         'importance' => $this->incident->importance,
    //         // Add other fields you might need for UI updates
    //     ];
    // }
}

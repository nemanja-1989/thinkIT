<?php

namespace App\Events\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LibrarianRecordEventAuthor implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $author;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Author $author)
    {
        $this->user = $user;
        $this->author = $author;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getUser() {
        return $this->user;
    }
}

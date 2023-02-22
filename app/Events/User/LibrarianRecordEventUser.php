<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LibrarianRecordEventUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $librarian;
    private $newUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $librarian, User $newUser)
    {
        $this->librarian = $librarian;
        $this->newUser = $newUser;
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

    public function getLibrarian() {
        return $this->librarian;
    }

    public function getNewUser() {
        return $this->newUser;
    }
}

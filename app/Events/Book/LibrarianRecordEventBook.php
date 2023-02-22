<?php

namespace App\Events\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LibrarianRecordEventBook implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $librarian;
    private $book;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $librarian, Book $book)
    {
        $this->librarian = $librarian;
        $this->book = $book;
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

    public function getBook() {
        return $this->book;
    }
}

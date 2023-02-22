<?php

namespace App\Listeners\Book;

use App\Events\Book\LibrarianRecordEventBook;
use App\Helpers\RoleConstants;
use App\Models\User;
use App\Notifications\Book\LibrarianStoreRecordBook;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LibrarianRecordNotificationBook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LibrarianRecordEventBook  $event
     * @return void
     */
    public function handle(LibrarianRecordEventBook $event)
    {
        //we don`t have admin, or any responsible person for tracking Librarian user store record,
        //and i decide to send notification to all Librarian users except Librarian who created.
        $librarianUsers = User::role(RoleConstants::LIBRARIAN['name'])
        ->where('id', '<>', $event->getLibrarian()->id)
        ->get();
        foreach($librarianUsers as $librarian) {
            $librarian->notify(new LibrarianStoreRecordBook($librarian, $event->getBook()));
        }
    }
}

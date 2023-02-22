<?php

namespace App\Listeners\Author;

use App\Events\Author\LibrarianRecordEventAuthor;
use App\Helpers\RoleConstants;
use App\Models\User;
use App\Notifications\Author\LibrarianStoreRecordAuthor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LibrarianRecordNotificationAuthor implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\LibrarianRecordEvent  $event
     * @return void
     */
    public function handle(LibrarianRecordEventAuthor $event)
    {
        //we don`t have admin, or any responsible person for tracking Librarian user store record,
        //and i decide to send notification to all Librarian users except Librarian who created.
        $librarianUsers = User::role(RoleConstants::LIBRARIAN['name'])
        ->where('id', '<>', $event->getUser()->id)
        ->get();
        foreach($librarianUsers as $librarian) {
            $librarian->notify(new LibrarianStoreRecordAuthor($librarian, $event->getAuthor()));
        }
    }
}

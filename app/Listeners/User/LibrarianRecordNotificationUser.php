<?php

namespace App\Listeners\User;

use App\Events\User\LibrarianRecordEventUser;
use App\Helpers\RoleConstants;
use App\Models\User;
use App\Notifications\User\LibrarianStoreRecordUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LibrarianRecordNotificationUser
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
     * @param  \App\Events\User\LibrarianRecordEventUser  $event
     * @return void
     */
    public function handle(LibrarianRecordEventUser $event)
    {
        //we don`t have admin, or any responsible person for tracking Librarian user store record,
        //and i decide to send notification to all Librarian users except Librarian who created.
        $librarianUsers = User::role(RoleConstants::LIBRARIAN['name'])
        ->where('id', '<>', $event->getLibrarian()->id)
        ->get();
        foreach($librarianUsers as $librarian) {
            $librarian->notify(new LibrarianStoreRecordUser($librarian, $event->getNewUser()));
        }
    }
}

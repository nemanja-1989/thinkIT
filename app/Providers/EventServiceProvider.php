<?php

namespace App\Providers;

use App\Events\Author\LibrarianRecordEventAuthor;
use App\Events\Book\LibrarianRecordEventBook;
use App\Events\User\LibrarianRecordEventUser;
use App\Listeners\Author\LibrarianRecordNotificationAuthor;
use App\Listeners\Book\LibrarianRecordNotificationBook;
use App\Listeners\User\LibrarianRecordNotificationUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            LibrarianRecordEventAuthor::class,
            [LibrarianRecordNotificationAuthor::class, 'handle']
        );

        Event::listen(
            LibrarianRecordEventBook::class,
            [LibrarianRecordNotificationBook::class, 'handle']
        );

        Event::listen(
            LibrarianRecordEventUser::class,
            [LibrarianRecordNotificationUser::class, 'handle']
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

<?php

namespace App\Providers;

use App\Contracts\Book\BookFilterInterface;
use App\Contracts\Book\BookInterface;
use App\Repositories\Book\BookFilterRepository;
use App\Repositories\Book\BookRepository;
use Illuminate\Support\ServiceProvider;

class BookInterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookInterface::class, BookRepository::class);
        $this->app->bind(BookFilterInterface::class, BookFilterRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

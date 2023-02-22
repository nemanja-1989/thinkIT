<?php

namespace App\Providers;

use App\Contracts\Author\AuthorInterface;
use App\Repositories\Author\AuthorRepository;
use Illuminate\Support\ServiceProvider;

class AuthorInterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorInterface::class, AuthorRepository::class);
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

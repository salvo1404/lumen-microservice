<?php

namespace App\Providers;

use App\Repositories\PlayerRepository;
use App\Repositories\PlayerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( PlayerRepositoryInterface::class, PlayerRepository::class);
    }
}

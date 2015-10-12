<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Core\User\UserSys;

class UserSysProvider extends ServiceProvider
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
        //
        $this->app->singleton('UserSys', function ($app) {
            return new UserSys();
        });
    }
}

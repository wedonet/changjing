<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\libraries\main;

class MainProvider extends ServiceProvider
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
        $this->app->bind('main', function () {
            $main = new main();
            return $main;
        });
    }
}

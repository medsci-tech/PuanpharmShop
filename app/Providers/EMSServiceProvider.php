<?php

namespace App\Providers;

use App\BasicShop\EMS\EMS;
use Illuminate\Support\ServiceProvider;

class EMSServiceProvider extends ServiceProvider
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
        $this->app->singleton('ems', function ($app) {
            return new EMS();
        });
    }
}

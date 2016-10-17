<?php

namespace App\Providers;

use App\BasicShop\Kdniao\Kdniao;
use Illuminate\Support\ServiceProvider;

class KdniaoServiceProvider extends ServiceProvider
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
        $this->app->singleton('kdniao', function ($app) {
            return new Kdniao();
        });
    }
}

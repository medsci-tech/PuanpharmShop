<?php

namespace App\Providers;

use App\BasicShop\Erp\Erp;
use Illuminate\Support\ServiceProvider;

class ErpServiceProvider extends ServiceProvider
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
        $this->app->singleton('erp', function () {
            return new Erp();
        });
    }
}

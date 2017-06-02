<?php

namespace App\Providers;

use App\BasicShop\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
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
        $this->app->singleton('cart', function ($app) {
            if (\Session::has('cart')) {
                return \Session::get('cart');
            }

            return new Cart();
        });
    }
}

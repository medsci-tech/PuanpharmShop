<?php

namespace App\BasicShop\Kdniao\Facades;

use Illuminate\Support\Facades\Facade;

class Kdniao extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kdniao';
    }
}
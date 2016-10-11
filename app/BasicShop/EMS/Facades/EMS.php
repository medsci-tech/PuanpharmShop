<?php

namespace App\BasicShop\EMS\Facades;

use Illuminate\Support\Facades\Facade;

class EMS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ems';
    }
}
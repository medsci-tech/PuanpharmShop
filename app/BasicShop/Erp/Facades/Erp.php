<?php
namespace App\BasicShop\Erp\Facades;

use Illuminate\Support\Facades\Facade;

class Erp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'erp';
    }
}
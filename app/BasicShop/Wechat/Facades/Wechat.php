<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2016/3/9
 * Time: 16:18
 */

namespace app\BasicShop\Wechat\Facades;

use Illuminate\Support\Facades\Facade;

class Wechat extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wechat';
    }
} /*class*/
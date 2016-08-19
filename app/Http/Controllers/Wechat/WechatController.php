<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Wechat;

class WechatController extends Controller
{

    public function serve()
    {
        $server = Wechat::getServer();
        return $server->serve();
    }

    public function menu()
    {
        if (Wechat::generateMenu()) {
            return 'success';
        } else {
            return 'failed';
        }
    }
}
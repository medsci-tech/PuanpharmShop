<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Wx\WxMember;
use Illuminate\Http\Request;

class WxController extends Controller
{
    /**
     * @var mixed
     */
    protected $phone;

    public function __construct()
    {
        $this->wxMember = WxMember::find(\Session::get('wx_member'));
    }
}

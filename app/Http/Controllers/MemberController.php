<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @var mixed
     */
    protected $phone;

    public function __construct()
    {
        $this->phone = \Session::get('phone');
    }
}

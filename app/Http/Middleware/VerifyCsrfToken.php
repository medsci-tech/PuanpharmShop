<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/admin/*',
        '/shop/cart/*',
        '/member/cart/*',
        '/wx/cart/*',
        '/shop/product-list',
        '/shop/product-specifications',
        '/shop/address/*',
        '/wechat*',
        '/admin/product/excel*',
        '/admin/product/update-puan-id*',
        '/outer-api/*'
    ];
}

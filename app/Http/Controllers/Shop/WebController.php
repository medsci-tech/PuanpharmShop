<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

/**
 * Class WebController
 * @package App\Http\Controllers\Shop
 */
class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.index', [
            'products' => Product::where('supplier_id', 1)->orderBy('weight', 'desc')->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        return view('web.detail', [
            'product' => Product::find($request->input('id'))
        ]);
    }
}
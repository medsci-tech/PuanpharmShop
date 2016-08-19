<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\WxController;

use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers\Member
 */
class CartController extends WxController
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dates = \Redis::command('hgetall', ['wx_id:' . $this->wxMember->id]);
        $products = [];
        foreach ($dates as $key => $value) {
            $array = explode('-', $key);
            $product = Product::find($array[0]);
            if (!$product) {
                \Redis::command('hdel', ['wx_id:' . $this->wxMember->id, $key]);
            }
            $product->quantity = $value;
            if (sizeof($array) > 1) {
                $product->specification = ProductSpecification::find($array[1]);
            }
            array_push($products, $product);
        }
        return view('wx.cart', ['products' => $products]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $id = $request->input('product_id');
        if (\Redis::command('HEXISTS', ['wx_id:' . $this->wxMember->id, $id])) {
            \Redis::command('HINCRBY', ['wx_id:' . $this->wxMember->id, $request->input('product_id'), $quantity]);
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => \Redis::command('hset', ['wx_id:' . $this->wxMember->id, $id, $quantity])
            ]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            return response()->json(['success' => false]);
        }
        if (\Redis::command('HEXISTS', ['wx_id:' . $this->wxMember->id, $id])) {
            return response()->json([
                'success' => \Redis::command('HSET', ['wx_id:' . $this->wxMember->id, $id, $quantity])
            ]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => \Redis::command('hgetall', ['wx_id:' . $this->wxMember->id])
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $productID = $request->input('product_id');
        if ($request->has('spec_id')) {
            $specID = $request->input('spec_id', 1);
            \Redis::command('hdel', ['wx_id:' . $this->wxMember->id, $productID . '-' . $specID]);
            return response()->json(['success' => true]);
        } else {
            \Redis::command('hdel', ['wx_id:' . $this->wxMember->id, $productID]);
            return response()->json(['success' => true]);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        $keys = \Redis::command('hkeys', ['wx_id:' . $this->wxMember->id]);
        if ($keys) {
            \Redis::command('hdel', ['wx_id:' . $this->wxMember->id, $keys]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => true]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        return response()->json([
            'success' => true,
            'count' => sizeof(\Redis::command('HKEYS', ['wx_id:' . $this->wxMember->id]))
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAll()
    {
        return response()->json(['success' => $keys = \Redis::command('flushall')]);
    }
}
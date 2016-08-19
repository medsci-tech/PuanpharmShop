<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\MemberController;

use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers\Member
 */
class CartController extends MemberController
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
        $dates = \Redis::command('hgetall', ['phone:' . $this->phone]);
        $products = [];
        foreach ($dates as $key => $value) {
            $array = explode('-', $key);
            $product = Product::find($array[0]);
            if (!$product) {
                \Redis::command('hdel', ['phone:' . $this->phone, $key]);
            }
            $product->quantity = $value;
            if (sizeof($array) > 1) {
                $product->specification = ProductSpecification::find($array[1]);
            }
            array_push($products, $product);
        }
        return view('member.cart', ['products' => $products]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $id = $request->input('product_id');
        if (\Redis::command('HEXISTS', ['phone:' . $this->phone, $id])) {
            \Redis::command('HINCRBY', ['phone:' . $this->phone, $request->input('product_id'), $quantity]);
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => \Redis::command('hset', ['phone:' . $this->phone, $id, $quantity])
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
        if (\Redis::command('HEXISTS', ['phone:' . $this->phone, $id])) {
            return response()->json([
                'success' => \Redis::command('HSET', ['phone:' . $this->phone, $id, $quantity])
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
            'data' => \Redis::command('hgetall', ['phone:' . $this->phone])
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
            \Redis::command('hdel', ['phone:' . $this->phone, $productID . '-' . $specID]);
            return response()->json(['success' => true]);
        } else {
            \Redis::command('hdel', ['phone:' . $this->phone, $productID]);
            return response()->json(['success' => true]);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        $keys = \Redis::command('hkeys', ['phone:' . $this->phone]);
        if ($keys) {
            \Redis::command('hdel', ['phone:' . $this->phone, $keys]);
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
            'count' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone]))
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
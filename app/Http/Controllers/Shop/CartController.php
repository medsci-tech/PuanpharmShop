<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->customerID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->id;
    }

    protected $customerID;

    /**
     * Display a listing of the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$keys = \Redis::command('HKEYS', ['user_id:' . $this->customerID]);
        $dates = \Redis::command('hgetall', ['user_id:' . $this->customerID]);
        $products = [];
        foreach ($dates as $key => $value) {
            $array = explode('-', $key);
            $product = Product::find($array[0]);
            if (!$product) {
                \Redis::command('hdel', ['user_id:' . $this->customerID, $key]);
            }
            $product->quantity = $value;
            if (sizeof($array) > 1) {
                $product->specification = ProductSpecification::find($array[1]);
            }
            array_push($products, $product);
        }
//        $products = Product::find($keys);
//        foreach ($products as &$product) {
//            $product->quantity = $dates[$product->id];
//        }
        return view('shop.cart', ['products' => $products]);
    }

    public function add(Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $id = $request->input('product_id');
        if (\Redis::command('HEXISTS', ['user_id:' . $this->customerID, $id])) {
            \Redis::command('HINCRBY', ['user_id:' . $this->customerID, $request->input('product_id'), $quantity]);
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => \Redis::command('hset', ['user_id:' . $this->customerID, $id, $quantity])
            ]);
        }

    }

    public function update(Request $request)
    {
        $id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            return response()->json(['success' => false]);
        }
        if (\Redis::command('HEXISTS', ['user_id:' . $this->customerID, $id])) {
            return response()->json([
                'success' => \Redis::command('HSET', ['user_id:' . $this->customerID, $id, $quantity])
            ]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => \Redis::command('hgetall', ['user_id:' . $this->customerID])
        ]);
    }

    public function delete(Request $request)
    {
//        $inputCount = $request->input('quantity', 1);
//        $productCount = \Redis::command('hget', ['user_id:' . $this->customerID, $request->input('product_id')]);
//        if ($inputCount >= $productCount) {
//            \Redis::command('hdel', ['user_id:' . $this->customerID, $request->input('product_id')]);
//        } else {
//            \Redis::command('HINCRBY', ['user_id:' . $this->customerID, $request->input('product_id'), -$inputCount]);
//        }
        $productID = $request->input('product_id');
        if ($request->has('spec_id')) {
            $specID = $request->input('spec_id', 1);
            \Redis::command('hdel', ['user_id:' . $this->customerID, $productID . '-' . $specID]);
            return response()->json(['success' => true]);
        } else {
            \Redis::command('hdel', ['user_id:' . $this->customerID, $productID]);
            return response()->json(['success' => true]);
        }

    }

    public function clear()
    {
        $keys = \Redis::command('hkeys', ['user_id:' . $this->customerID]);
        if ($keys) {
            \Redis::command('hdel', ['user_id:' . $this->customerID, $keys]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => true]);
        }
    }

    public function count()
    {
        return response()->json([
            'success' => true,
            'count' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
        ]);
    }

    public function clearAll()
    {
        return response()->json(['success' => $keys = \Redis::command('flushall')]);
    }
}
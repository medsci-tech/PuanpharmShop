<?php

namespace App\Http\Controllers\Shop;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis;

class CouponController extends Controller
{
    protected $customerID;

    public function __construct()
    {
        $this->customerID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->id;
    }


    public function index()
    {
        return Customer::find($this->customerID)->coupons;
    }

    public function applyInCart(Request $request)
    {
        $coupon_id = $request->input('coupon_id');
        $coupon = Coupon::find($coupon_id);

        $cart = Redis::command('HGETALL', ['user_id:'. $this->customerID]);
        if (!$cart) {
            return response('No item in cart.', 500);
        }

        $total_money = 0;
        foreach ($cart as $k => $v) {
            $array = explode('-', $k);
            $product = Product::find($array[0]);

            if (!$product) {
                Redis::command('HDEL', ['user_id:' . $this->customerID, $k]);
            }
            $total_money += $product->price * $v;
        }


        if ($coupon->validateForTotalMoney($total_money)) {
            Redis::command('HSET', ['user_id:'. $this->customerID, 'coupon', $coupon_id]);
        }
    }

    public function addCoupon(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|exists:customers',
            'coupon_type_id' => 'required|exists:coupon_types'
        ]);
        $phone = $request->input('phone');
        $coupon_type_id = $request->input('coupon_type_id');
        $amount = $request->input('amount', 1);

        $customer = Customer::where('phone', $phone)->first();

        for ($i = 0; $i < $amount; $i++) {
            $coupon = new Coupon();
            $coupon->customer_id = $customer->id;
            $coupon->coupon_type_id = $coupon_type_id;
            $coupon->source = '易康伴侣';
            $coupon->save();
        }

        return response()->json([
            'success' => true
        ]);
    }
}

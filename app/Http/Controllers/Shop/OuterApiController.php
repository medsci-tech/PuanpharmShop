<?php

namespace App\Http\Controllers\Shop;

use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OuterApiController extends Controller
{
    public function addCoupon(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|exists:customers',
            'coupon_type_id' => 'required|exists:coupon_types,id'
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

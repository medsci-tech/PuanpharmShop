<?php

namespace App\Http\Controllers\Shop;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\StashedCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OuterApiController extends Controller
{
    public function addCoupon(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'unionid' => 'required',
            'coupon_type_id' => 'required|exists:coupon_types,id',
            'amount' => 'integer|min:1',
            'expire_at' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false'
            ]);
        }

        $unionid = $request->input('unionid');
        $coupon_type_id = $request->input('coupon_type_id');
        $amount = $request->input('amount', 1);
        $expire_at = $request->input('expire_at', null);

        if ($expire_at) {
            $expire_at_carbon = Carbon::createFromTimestamp(strtotime($expire_at));
        } else {
            $expire_at_carbon = Carbon::now()->addMonth(1);
        }

        if ($customer = Customer::where('unionid', $unionid)->first()) {
            for ($i = 0; $i < $amount; $i++) {
                $coupon = new Coupon();
                $coupon->customer_id = $customer->id;
                $coupon->coupon_type_id = $coupon_type_id;
                $coupon->source = '易康伴侣';
                $coupon->expire_at = $expire_at_carbon;
                $coupon->save();
            }
        } else {
            for ($i = 0; $i < $amount; $i++) {
                $coupon = new StashedCoupon();
                $coupon->unionid = $unionid;
                $coupon->coupon_type_id = $coupon_type_id;
                $coupon->source = '易康伴侣';
                $coupon->expire_at = $expire_at_carbon;
                $coupon->save();
            }
        }

        return response()->json([
            'success' => true
        ]);
    }
}

<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Utils\XML;

class PaymentController extends Controller
{
    public function notify(Request $request)
    {
        \Log::info('payment/wx-notify-result: ' . $request->getContent());
        $input = XML::parse($request->getContent());
        if ($input['return_code'] == 'SUCCESS') {
            //\DB::transaction(function() use($input) {
            $outTradeNo = $input['out_trade_no'];
            $idArray = explode("-", $outTradeNo);
            array_shift($idArray);
            $result = Order::whereIn('id', $idArray)->where('payment_status', 0)->update(['payment_status' => 1, 'out_trade_no' => $input['out_trade_no']]);
            \Log::info('order_result', ['result' => $result]);

            if (!$result) {
                return 'FAIL';
            }

            //$beansResult = $customer->consumeBackBeans($input['total_fee'] / 100 * config('bean.bean_consume_rate'));
            //\Log::debug('consume_back_beans', ['result' => $beansResult]);

            $customer = Customer::where('openid', $input['openid'])->first();
            $customer->wxPaymentDetails()->create($input);
            $order = Order::find($idArray[0]);
            // Í¬²½Âõ¶¹
            if ($customer->unionid) {
                \Helper::updateBeansByUnionid($customer->unionid, $order->beans_fee * 100);
            }

            $result = \Wechat::paymentNotify();
            return $result;
        }
        return 'FAIL';
    }
}

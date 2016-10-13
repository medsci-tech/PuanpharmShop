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
            $outTradeNo = $input['out_trade_no'];
            $idArray = explode("-", $outTradeNo);
            array_shift($idArray);
            $result = Order::whereIn('id', $idArray)->where('payment_status', 0)->update(['payment_status' => 1, 'out_trade_no' => $input['out_trade_no']]);
            \Log::info('order_result', ['result' => $result]);
            if ($result) {
                // 迈豆返现
                //$beansResult = $customer->consumeBackBeans($input['total_fee'] / 100 * config('bean.bean_consume_rate'));
                //\Log::debug('consume_back_beans', ['result' => $beansResult]);

                // 支付回调
                $customer = Customer::where('openid', $input['openid'])->first();
                $customer->wxPaymentDetails()->create($input);

                // 扣除易康迈豆
                $order = Order::find($idArray[0]);
                if ($customer->unionid) {
                    \Helper::updateBeansByUnionid($customer->unionid, $order->beans_fee * 100);
                }

                // 短信提醒
                $orders = Order::whereIn('id', $idArray)->get();
                foreach($orders as $order) {
                    //\Message::createMessage($order->address_phone, '您好,感谢您在普安易康购物! 我们很高兴地通知您, 您的商品订单已经收到。请保持手机畅通，以便送货人员能及时联系到您。');
                }

                $result = \Wechat::paymentNotify();
                return $result;
            } else {
                return 'FAIL';
            }
        } else {
            return 'FAIL';
        }
    }
}

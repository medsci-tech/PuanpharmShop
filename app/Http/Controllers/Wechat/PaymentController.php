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
                // $beansResult = $customer->consumeBackBeans($input['total_fee'] / 100 * config('bean.bean_consume_rate'));
                // \Log::debug('consume_back_beans', ['result' => $beansResult]);

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
                    if($order->supplier_id == 2) {
                        \Message::createMessage($order->address_phone, '尊敬的顾客您好！您在易康商城购买的货品订单号为['.$order->order_sn.'-'.$order->id.']，将由普安药房尽快为您安排发货，如有任何问题您可以拨打客服电话：4001199802进行咨询，感谢您的惠顾！');
                    } else {
                        // 海外直邮
                        \Message::createMessage($order->address_phone, '尊敬的顾客您好！您在易康商城购买的货品订单号为['.$order->order_sn.'-'.$order->id.']，我们将尽快为您安排发货，如有任何问题您可以拨打客服电话：4001199802进行咨询，感谢您的惠顾！');
                    }
                }
                $result = \Wechat::paymentNotify();
                /* 同步注册用户通行证验证 */
                $cash_paid = $order->total_fee-$order->beans_fee; // 实际支付
                $post_data = array("cash_paid_by_beans" => $order->beans_fee, "phone" => $customer->phone,'cash_paid'=> $cash_paid);
                \Helper::tocurl(env('API_URL'). '/consume', $post_data,1);

                return $result;
            } else {
                return 'FAIL';
            }
        } else {
            return 'FAIL';
        }
    }
}

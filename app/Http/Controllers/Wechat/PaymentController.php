<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Utils\XML;
use Curl\Curl;
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
            if (Order::find($idArray[0])->payment_status == 0) {
                $order_first = Order::whereIn('id', $idArray)->first();
                \Log::info('order_to_pay', ['a' => $order_first]);
                if ($order_first->coupon_id) {
                    $order_first->coupon()->update(['used' => 1]);
                }
                $result = Order::whereIn('id', $idArray)->update(['payment_status' => 1, 'out_trade_no' => $input['out_trade_no']]);
                \Log::info('order_to_pay2', ['a' => $order_first]);
                \Log::info('order_result', ['result' => $result]);

                $this->addProductSoldCount(Order::whereIn('id', $idArray)->get());

                if ($result) {
                    // 支付回调
                    $customer = Customer::where('openid', $input['openid'])->first();
                    $customer->wxPaymentDetails()->create($input);

                    $this->callForOuterConsumeAction($customer, $idArray);

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

                    return $result;
                } else {
                    return 'FAIL';
                }
            }


        } else {
            return 'FAIL';
        }
    }

    public function addProductSoldCount($orders)
    {
        /** @var Order $order */
        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity;
                $product->sold_count += $quantity;
                $product->save();
            }
        }
    }

    /**
     * @param Customer $customer
     * @param          $id_array
     */
    public function callForOuterConsumeAction($customer, $id_array)
    {
        try {
            \Log::info('outer api log: '. $customer->id . ' ' . implode("-", $id_array));
            $unionid = $customer->unionid;

            if (Order::where('customer_id', $customer->id)->where('payment_status', 1)->whereNotIn('id', $id_array)->count() == 0) {
                \Log::info('first order!');
                $result = $this->callOrderFirstApi($unionid);

                \Log::info('first order result: '.$result->response);

            }

            $money = Order::whereIn('id', $id_array)->get()->sum('pay_fee');
            \Log::info('call outer api');

            $ordersn = $id_array[0];

            $result = $this->callOrderBuyApi($unionid, $money, $ordersn);
            \Log::info('order buy result: '.$result->response);

        } catch (\Exception $exception) {
            \Log::error('call outer api exception: '. $exception->getMessage());
        }
    }

    /**
     * @param $unionid
     * @return \Curl\Curl
     */
    public static function callOrderFirstApi($unionid)
    {
        $curl = new Curl();
        $time = time();
        $a = env('OUTER_API_PHASE_A');
        $b = env('OUTER_API_PHASE_B');
        $token = sha1($a.$unionid.$time.$b);

        return $curl->get('http://www.ohmate.cn/index.php?g=api&m=puan&a=order_first&un=' . $unionid . '&time=' . $time . '&token=' . $token);
    }


    /**
     * @param $unionid
     * @param $money
     * @return \Curl\Curl
     */
    public static function callOrderBuyApi($unionid, $money, $ordersn)
    {
        $curl = new Curl();
        $time = time();
        $a = env('OUTER_API_PHASE_A');
        $b = env('OUTER_API_PHASE_B');
        $token = sha1($a.$unionid.$money.$time.$b);

        return $curl->get('http://www.ohmate.cn/index.php?g=api&m=puan&a=order_buy&un=' . $unionid . '&money=' . $money . '&time=' . $time . '&token=' . $token . '&orderno=' . $ordersn);
    }
}

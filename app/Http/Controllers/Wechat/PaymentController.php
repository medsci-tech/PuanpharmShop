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
            $order_to_pay = Order::whereIn('id', $idArray);
            \Log::info('order_to_pay', ['a' => $order_to_pay->first()]);
            if ($order_to_pay->first()->coupon_id) {
                $order_to_pay->first()->coupon()->update(['used' => 1]);
            }
            $result = $order_to_pay->update(['payment_status' => 1, 'out_trade_no' => $input['out_trade_no']]);
            \Log::info('order_to_pay2', ['a' => $order_to_pay->first()]);
            \Log::info('order_result', ['result' => $result]);

            $this->addProductSoldCount($order_to_pay->get());

            if ($result) {
                // 迈豆返现
                // $beansResult = $customer->consumeBackBeans($input['total_fee'] / 100 * config('bean.bean_consume_rate'));
                // \Log::debug('consume_back_beans', ['result' => $beansResult]);

                // 支付回调
                $customer = Customer::where('openid', $input['openid'])->first();
                $customer->wxPaymentDetails()->create($input);

                $this->callForOuterConsumeAction($customer, $idArray);

                // 扣除易康迈豆
                $order = Order::find($idArray[0]);
                if ($customer->unionid) {
                    \Helper::updateBeansByUnionid($customer->unionid, $order->beans_fee * 100);
                }
                /* 同步用户通行证验证 */
                $count = Order::where(['customer_id'=>$customer->id,'payment_status'=>1])->count(); // 统计
                $is_first_cash_consume = $count==1 ? 1 : 0; // 是否首单消费
                if(!$customer->phone) // 获取手机号
                {
                    $curl = new Curl();
                    $curl->get('http://www.ohmate.cn/puan/phone-by-union-id?unionid='.$customer->unionid);
                    $data = json_decode($curl->response,true);
                    if($data['phone'])
                    {
                        $customer->phone=$data['phone'];
                        $customer->save();
                    }
                    $phone = $data['phone'];
                }
                else
                    $phone = $customer->phone;

                $cash_paid = $order->total_fee-$order->beans_fee; // 实际支付
                $post_data = array("cash_paid_by_beans" => $order->beans_fee, "phone" => $phone,'cash_paid'=> $cash_paid,'is_first_cash_consume'=>$is_first_cash_consume);
                /* 同步查询用户通行证验证 */
                $res = \Helper::tocurl(env('API_URL'). '/query-user-information?phone='.$phone, $post=array(),0);
                $beans_total  = isset($res['phone']) ? 0 : $res['result']['bean']['number']; //购买前剩余迈豆
                $res2 = \Helper::tocurl(env('API_URL'). '/consume', $post_data,1); // 同步消费扣积分
                $bean_rest = isset($res2['bean_rest']) ? $res2['bean_rest'] : null; //买后剩余积分
                \Log::info('post_data', ['post_data' => $post_data,'response'=> $res2,'bean'=>array('bean_before'=>$beans_total,'beans_after'=>$bean_rest)]); // 文件日志记录
                
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

            $result = $this->callOrderBuyApi($unionid, $money);
            \Log::info('first order result: '.$result->response);

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
    public static function callOrderBuyApi($unionid, $money)
    {
        $curl = new Curl();
        $time = time();
        $a = env('OUTER_API_PHASE_A');
        $b = env('OUTER_API_PHASE_B');
        $token = sha1($a.$unionid.$money.$time.$b);

        return $curl->get('http://www.ohmate.cn/index.php?g=api&m=puan&a=order_buy&un=' . $unionid . '&money=' . $money . '&time=' . $time . '&token=' . $token);
    }
}

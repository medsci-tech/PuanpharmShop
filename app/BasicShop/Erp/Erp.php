<?php

namespace App\BasicShop\Erp;

/**
 * Class Erp
 * @package App\BasicShop\Erp
 */
use App\Models\Order;

/**
 * Class Erp
 * @package App\BasicShop\Erp
 */
class Erp
{
    /**
     * @var string
     */
    private $appkey;
    /**
     * @var string
     */
    private $sessionkey;
    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $url = 'http://api.guanyierp.com/rest/erp_open';

    /**
     *
     */
    public function __construct()
    {
        $this->appkey = env('ERP_APP_KEY');
        $this->sessionkey = env('ERP_SESSION_KEY');
        $this->secret = env('ERP_SECRET');
    }


    /**
     * @param $data
     * @return mixed
     */
    private function format($data)
    {
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $data['sign'] = md5($this->secret . json_encode($data) . $this->secret);
        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function formatOrder($data)
    {
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $param = [
            'json' => json_encode($data),
            'secret' => $this->secret,
        ];
        $content = json_encode($param);
        $request = [
            'headers' => ['Content-Type: application/json'],
            'url' => '106.75.134.39:9002/test/signJson',
            'content' => $content
        ];

        $response = \HttpClient::post($request);
        //dd($response);
        //dd($response->json()->data->sign);
        $data['sign'] = $response->json()->data->sign;
        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function post($data)
    {
        $data = $this->format($data);
        $content = json_encode($data);
        //dd($content);
        $response = \HttpClient::post(['headers' => ['Content-Type: application/json'], 'url' => $this->url, 'content' => $content]);
        return $response->json();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function postOrder($data)
    {
        $data = $this->formatOrder($data);
        $content = json_encode($data);

        $response = \HttpClient::post(['headers' => ['Content-Type: application/json'], 'url' => $this->url, 'content' => $content]);
        return $response->json();
    }


    /****************************************************
     ****************** demo from puan ******************
     ****************************************************/

    /**
     * @param $url
     * @param $data
     * @return mixed
     */
    function mycurl($url, $data)
    {
        $data_string = $this->json_encode_ch($data);
        //echo 'request: ' . $data_string . "\n";
        $data_string = urlencode($data_string);
        var_dump($data_string);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:text/json;charset=utf-8',
            'Content-Length:' . strlen($data_string)
        ));
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    /**
     * @return string
     */
    function getShops()
    {
        $data = array();
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $data['method'] = 'gy.erp.shop.get';
        $data['page_no'] = '1';
        $data['page_size'] = '10';
        // $data['code'] = '001';
        $data['sign'] = $this->sign($data, $this->secret);
        return 'response: ' . $this->mycurl($this->url, $data);
    }

    /**
     * @return string
     */
    function getWarehouses()
    {
        $data = array();
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $data['method'] = 'gy.erp.warehouse.get';
        $data['page_no'] = '1';
        $data['page_size'] = '10';
        // $data['code'] = '001';
        $data['sign'] = $this->sign($data, $this->secret);
        return 'response: ' . $this->mycurl($this->url, $data);
    }

    /**
     * @param $data
     * @param $secret
     * @return string
     */
    protected function sign($data, $secret)
    {
        if (empty($data)) {
            return "";
        }
        unset($data['sign']); //可选，具体看传参
        $data = $this->json_encode_ch($data);
        $sign = strtoupper(md5($secret . $data . $secret));
        return $sign;
    }

    /**
     * @param $arr
     * @return string
     */
    protected function json_encode_ch($arr)
    {
        return urldecode(json_encode($this->url_encode_arr($arr)));
    }

    /**
     * @param $arr
     * @return array|string
     */
    protected function url_encode_arr($arr)
    {
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                $arr[$k] = $this->url_encode_arr($v);
            }
        } elseif (!is_numeric($arr) && !is_bool($arr)) {
            $arr = urlencode($arr);
        }
        return $arr;
    }

    function addGoods()
    {
        $data = array();
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $data['method'] = 'gy.erp.item.add';
        $random_code = time(); //获取当前时间戳，以时间戳做商品代码可以防止重复，避免出错，此方式仅为测试
        $data['code'] = $random_code;
        $data['name'] = 'test';
        $data['simple_name'] = 'test';
        $data['weight'] = '124.00';
        $skus = array();
        $skus[] = array(
            'sku_code' => $random_code . '011',
            'sku_name' => 'S',
            'sku_sales_price' => '12.00',
            'sku_note' => ''
        );
        $skus[] = array(
            'sku_code' => $random_code . '012',
            'sku_name' => 'M',
            'sku_sales_price' => '12.00',
            'sku_note' => ''
        );
        $data['skus'] = $skus;
        $data['sign'] = $this->sign($data, $this->secret);
        return 'response: ' . $this->mycurl($this->url, $data);
    }

    function addTrade($orderID)
    {
        $order = Order::find($orderID);
        $data = [
            "appkey" => $this->appkey,
            "sessionkey" => $this->sessionkey,
            "method" => "gy.erp.trade.add",
            "order_type_code" => "Sales",
            "refund" => 0,
            "cod" => false,
            "warehouse_code" => "易康伴侣",
            "shop_code" => "易康伴侣",
            "express_code" => "htky",
            "platform_code" => $order->out_trade_no,
            "deal_datetime" => $order->created_at,
            "pay_datetime" => $order->created_at,
            "business_man_code" => "",
            "vip_code" => $order->address_name,
            "vip_name" => $order->address_name,
            "post_fee" => 0,
            "cod_fee" => 0,
            "discount_fee" => 0,
            "tag_code" => "1",
            "plan_delivery_date" => "",
            "buyer_memo" => "",
            "seller_memo" => "",
            "extend_memo" => "",
            "seller_memo_late" => "",
            "receiver_name" => $order->address_name,
            "receiver_phone" => $order->address_phone,
            "receiver_mobile" => $order->address_phone,
            "receiver_address" => $order->address_detail,
            "receiver_province" => $order->address_province,
            "receiver_city" => $order->address_city,
            "receiver_district" => $order->address_district,
            "vipRealName" => "",
            "vipIdCard" => "",
            "vipEmail" => "",
            "details" => [],
            "payments" => [],
        ];
        foreach ($order->products as $product) {
            array_push($data['details'], [
                "oid" => $orderID . '-' . $product->id,
                "item_code" => $product->id,
                "sku_code" => "",
                "price" => 1,
                "qty" => $product->quantity,
                "refund" => 0
            ]);

            array_push($data['payments'], [
                "pay_type_code" => "cash",
                "payment" => 1,
                "pay_code" => "",
                "paytime" => time()
            ]);
        }
        $data['sign'] = $this->sign($data, $this->secret);

//        $data = [
//            "appkey" => $this->appkey,
//            "sessionkey" => $this->sessionkey,
//            "method" => "gy.erp.trade.add",
//            "order_type_code" => "Sales",
//            "refund" => 0, "cod" => false,
//            "warehouse_code" => "易康伴侣",
//            "shop_code" => "易康伴侣",
//            "express_code" => "htky",
//            "platform_code" => '123-123',
//            "deal_datetime" => "2016-10-27 19:44:15",
//            "pay_datetime" => "2016-10-27 19:44:15",
//            "business_man_code" => "",
//            "tag_code" => "1",
//            "post_fee" => 0,
//            "cod_fee" => 0,
//            "discount_fee" => 0,
//            "plan_delivery_date" => "",
//            "vip_code" => "呵呵测试测试",
//            "vip_name" => "哈测试哈",
//            "buyer_memo" => "",
//            "seller_memo" => "",
//            "extend_memo" => "",
//            "seller_memo_late" => "",
//            "receiver_name" => "asdasd",
//            "receiver_phone" => "",
//            "receiver_mobile" => "13659856965",
//            "receiver_address" => "贵州省毕节黔西县迎宾小区5栋2单元202",
//            "receiver_province" => "贵州省",
//            "receiver_city" => "毕节市",
//            "receiver_district" => "黔西县",
//            "vipRealName" => "",
//            "vipIdCard" => "",
//            "vipEmail" => "",
//            "details" => [
//                [
//                    "oid" => "12234-12",
//                    "item_code" => "1234564321",
//                    "sku_code" => "",
//                    "price" => "16.96",
//                    "qty" => 1,
//                    "refund" => 0]],
//            "payments" => [
//                [
//                    "pay_type_code" => "cash",
//                    "payment" => 0,
//                    "pay_code" => "", "paytime" => time()]]
//        ];

        $data['sign'] = $this->sign($data, $this->secret);
        return $this->mycurl($this->url, $data);
    }
}
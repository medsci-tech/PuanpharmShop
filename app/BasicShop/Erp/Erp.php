<?php

namespace App\BasicShop\Erp;

/**
 * Class Erp
 * @package App\BasicShop\Erp
 */
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
        $data['sign'] = sign($data, $this->secret);
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
}
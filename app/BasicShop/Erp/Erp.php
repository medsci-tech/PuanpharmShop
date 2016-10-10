<?php

namespace App\BasicShop\Erp;

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


    private function format($data)
    {
        $data['appkey'] = $this->appkey;
        $data['sessionkey'] = $this->sessionkey;
        $data['sign'] = md5($this->secret . json_encode($data) . $this->secret);
        return $data;
    }

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

    public function post($data) {
        $data = $this->format($data);
        $content = json_encode($data);
        //dd($content);
        $response = \HttpClient::post(['headers' => ['Content-Type: application/json'], 'url' => $this->url, 'content' => $content]);
        return $response->json();
    }

    public function postOrder($data) {
        $data = $this->formatOrder($data);
        $content = json_encode($data);

        $response = \HttpClient::post(['headers' => ['Content-Type: application/json'], 'url' => $this->url, 'content' => $content]);
        return $response->json();
    }
}
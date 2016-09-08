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

    public function post($data) {
        $data = $this->format($data);
        $content = json_encode($data);
        $response = \HttpClient::post(['headers' => ['Content-Type: application/json'], 'url' => $this->url, 'content' => $content]);
        return $response->json();
    }
}
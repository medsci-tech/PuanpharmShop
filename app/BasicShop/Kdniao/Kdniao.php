<?php

namespace App\BasicShop\Kdniao;

/**
 * Class EMS
 * @package App\BasicShop\EMS
 */
class Kdniao
{
    private $businessID = 1267065;
    private $APIKey = '453b4009-2c5c-4cbc-a98e-b04295f3473a';
    private $reqURL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';

    function getOrderTracesByJson($shipperCode, $orderNum)
    {
        $requestData = "{'OrderCode':" . $orderNum . ", 'ShipperCode':'EMS', 'LogisticCode':'".time()."'}";

        $data = array(
            'EBusinessID' => $this->businessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $data['DataSign'] = $this->encrypt($requestData);
        $result = $this->sendPost($this->reqURL, $data);

        //根据公司业务处理返回的信息......

        return $result;
    }

    function sendPost($url, $datas)
    {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if ($url_info['port'] == '') {
            $url_info['port'] = 80;
        }
        echo $url_info['port'];
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        $httpheader .= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    function encrypt($data)
    {
        return urlencode(base64_encode(md5($data . $this->APIKey)));
    }
}
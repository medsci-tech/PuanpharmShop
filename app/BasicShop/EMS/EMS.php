<?php

namespace App\BasicShop\EMS;

/**
 * Class EMS
 * @package App\BasicShop\EMS
 */
class EMS
{
    /**
     * @var string
     */
    protected $sysAccount = 'A1234567890Z';
    /**
     * @var string
     */
    protected $passWord = 'e10adc3949ba59abbe56e057f20f883e';

    /**
     * @throws \Exception
     */
    public function test() {
        $url = 'http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do';

        $data = [
            'sysAccount' => $this->sysAccount,
            'passWord' => $this->passWord,
            'businessType' => 1,
            'billNoAmount' => 10
        ];
        $xml = base64_encode($this->arrayToXml($data));

        $request = [
            'url' =>  $url,
            'params' => [
                'method' => 'getBillNumBySys',
                'xml' => $xml
            ]
        ];

        $response = \HttpClient::get($request);
        $result = $this->xmlToArray(base64_decode($response->content()));
        if($result['result'] == 1) {
            return $result['assignIds'];
        } else {
            throw new \Exception($result['errorDesc']);
        }
    }


    /**
     * @param $array
     * @return string
     * @throws \Exception
     */
    function arrayToXml($array)
    {
        if (!is_array($array)
            || count($array) <= 0
        ) {
            throw new \Exception("数组数据异常！");
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?><XMLInfo>';
        foreach ($array as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= '</XMLInfo>';
        return $xml;
    }

    /**
     * @param $xml
     * @return mixed
     * @throws \Exception
     */
    function xmlToArray($xml)
    {
        if (!$xml) {
            throw new \Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array;
    }
}
<?php

namespace App\BasicShop\EMS;

use App\Models\Order;

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
     * @return mixed
     * @throws \Exception
     */
    public function getBillNum()
    {
        $url = 'http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do';

        $data = [
            'sysAccount' => $this->sysAccount,
            'passWord' => $this->passWord,
            'businessType' => 1,// 业务类型， 1为标准快递，4为经济快递
            'billNoAmount' => 1
        ];
        $xml = base64_encode($this->buildXml($data));

        $request = [
            'url' => $url,
            'params' => [
                'method' => 'getBillNumBySys',
                'xml' => $xml
            ]
        ];

        $response = \HttpClient::get($request);
        $result = $this->xmlToArray(base64_decode($response->content()));
        if ($result['result'] == 1) {
            return $result['assignIds']['assignId']['billno'];
        } else {
            throw new \Exception($result['errorDesc']);
        }
    }

    /**
     * @param $orderID
     * @return bool
     * @throws \Exception
     */
    function updatePrintData($orderID)
    {
        $billNum = $this->getBillNum();
        echo $billNum;
        $order = Order::find($orderID);
        $url = 'http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do';

        $data = [
            'sysAccount' => $this->sysAccount,
            'passWord' => $this->passWord,
            'printKind' => 2,// 打印类型，1为五联单打印，2为热敏打印
            'printDatas' => [
                'printData' => [
                    'bigAccountDataId' => $order->order_sn . '-' . $order->id,
                    'billno' => $billNum,
                    'scontactor' => '寄件人姓名',
                    'scustMobile' => '寄件人联系方式',
                    'scustPost' => '寄件人邮编',
                    'scustAddr' => '寄件人地址',
                    'scustComp' => '寄件人公司',
                    'tcontactor' => $order->address_name,
                    'tcustMobile' => $order->address_phone,
                    'tcustAddr' => $order->address_detail,
                    'tcustProvince' => $order->address_province,
                    'tcustCity' => $order->address_city,
                    'tcustCounty' => $order->address_detail,
                    'cargoType' => '物品',
//                    'tcustPost' => '收件人邮编',
//                    'weight' => '',
//                    'length' => '',
//                    'insure' => '',
//                    'tcustComp' => '',
//                    'remark' => '测试'
                ]
            ]
        ];

        $xml = base64_encode($this->buildXml($data));

        $request = [
            'url' => $url,
            'params' => [
                'method' => 'updatePrintDatas',
                'xml' => $xml
            ]
        ];

        $response = \HttpClient::get($request);
        $result = $this->xmlToArray(base64_decode($response->content()));
        if ($result['result'] == 1) {
            dd($result);
            return true;
        } else {
            throw new \Exception($result['errorDesc']);
        }
    }

    /**
     * @param array $array
     * @return string
     */
    function buildXml($array)
    {
        $xml = $this->arrayToXml($array);
        return '<?xml version="1.0" encoding="UTF-8"?><XMLInfo>' . $xml . '</XMLInfo>';
    }

    /**
     * @param string $xml
     * @param array $array
     * @return string
     */
    function arrayToXml($array, $xml = '')
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->arrayToXml($val, $xml) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
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
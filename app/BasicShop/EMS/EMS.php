<?php

namespace App\BasicShop\EMS;

/**
 * Class EMS
 * @package App\BasicShop\EMS
 */
class EMS
{
    private $url = 'http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do?method=updatePrintDatas&xml=""';






    function arrayToXml($array)
    {
        if (!is_array($array)
            || count($array) <= 0
        ) {
            throw new \Exception("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($array as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

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
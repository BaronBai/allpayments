<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 15:52
 */

namespace Mzt\AllPayments;


use Mzt\AllPayments\Contracts\IXml2Array;

class XmlArray implements IXml2Array
{
    public function toArray(string $xml) : array {

        if(!$xml){
            throw new \Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xml = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $xml;

    }


    public function toXml(array $arr): string
    {
        if(!is_array($arr) || count($arr) <= 0)
        {
            throw new \Exception("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}
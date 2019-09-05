<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 17:54
 */

namespace Mzt\AllPayments\Utils;


use Mzt\AllPayments\Contracts\ISignUtil;

class JDSignUtil implements ISignUtil
{

    public function sign(array $data, string $key): string
    {
        $unSignKeyList = array ("sign");
        $signSourceData = $this->signString($data,$unSignKeyList);
        $sign = md5($signSourceData.$key);
        return $sign;
    }

    public function verifySign(array $data, string $key, string $sign = ''): bool
    {
        $unSignKeyList = array ("sign");

        $signData = $this->signString($data,$unSignKeyList);

        $str = md5($signData.$key);
        return $sign == $str;
    }


    protected  function signString(array $data, array $unSignKeyList) {
        $linkStr = "";
        $isFirst = true;
        ksort($data);
        foreach ($data as $key => $value) {
            if (!is_numeric($value) && ($value == null || $value == "")) {
                continue;
            }
            $bool = false;
            foreach ($unSignKeyList as $str) {
                if ($key . "" == $str . "") {
                    $bool = true;
                    break;
                }
            }
            if ($bool) {
                continue;
            }
            if (!$isFirst) {
                $linkStr .= "&";
            }
            $linkStr .= $key . "=" . $value;
            if ($isFirst) {
                $isFirst = false;
            }
        }
        return $linkStr;
    }
}
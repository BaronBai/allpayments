<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 15:20
 */

namespace Mzt\AllPayments\Traits;


use Mzt\AllPayments\Contracts\ISignUtil;

class Md5SignUtil implements ISignUtil
{

    protected function toUrlParams(array $data){
        $buff = "";
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }


    public function sign(array $data, string $key) : string {
        ksort($data);
        $params = $this->toUrlParams($data);
        $params .= "&key=".$key;
        $params = urldecode($params);

        $result = strtoupper(md5($params));
        return $result;
    }


    public function verifySign(array $data, string $key, string $sign = '') : bool {
        $sign = $sign ? $sign : $data['sign'];

        if (array_key_exists('sign',$data)){
            unset($data['sign']);
        }

        $temp = $this->sign($data,$key);
        return $temp == $sign;
    }
}
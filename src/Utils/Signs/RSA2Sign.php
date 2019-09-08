<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/6
 * Time: 17:39
 */

namespace Mzt\AllPayments\Utils\Signs;


use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Exceptions\ApplicationException;
use Mzt\AllPayments\Exceptions\SignException;

class RSA2Sign implements ISignUtil
{

    public function sign(array $data, string $key): string
    {
        $sign = '';
        $content = "";

        if (is_file($key)){
            $privateKey = file_get_contents($key);
            $res = openssl_get_privatekey($privateKey);
        }else{
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($key, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        }

        if (!$res){
            throw new SignException("RAS2 sign fail! ");
        }

        ksort($data);
        foreach ($data as $key => $value){
            $content .= trim($key).'='.trim($value).'&';
        }

        $content = trim($content,'&');

        openssl_sign($content,$sign,$res,OPENSSL_ALGO_SHA256);
        $result = base64_encode($sign);

        if (is_file($key)){
            openssl_free_key($res);
        }
        return $result;
    }

    public function verifySign(array $data, string $key, string $sign = ''): bool
    {
        if (is_file($key)){
            $privateKey = file_get_contents($key);
            $res = openssl_get_privatekey($privateKey);
        }else{
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($key, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        }

        if (!$res){
            throw new SignException("RAS2 verify fail! ");
        }

        ksort($data);
        $query = urldecode(http_build_query($data));
        $result = (openssl_verify($query, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1 );

        if (is_file($key)){
            openssl_free_key($res);
        }
        return $result;
    }
}
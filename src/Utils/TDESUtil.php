<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 17:52
 */

namespace Mzt\AllPayments\Utils;


class TDESUtil
{
    public static function encrypt($str, $key)
    {
        $key = base64_decode($key);
        $pad = 8 - (strlen($str) % 8);
        $str = $str . str_repeat(chr($pad), $pad);

        if (strlen($str) % 8) {
            $str = str_pad($str, strlen($str) + 8 - strlen($str) % 8, "\0");
        }
        $str = openssl_encrypt($str, 'DES-EDE3', $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, '');
        return bin2hex($str);
    }

    public static function decrypt($str, $key)
    {
        $key = base64_decode($key);
        $str = pack("H*", $str);
        $str = openssl_decrypt($str, 'DES-EDE3', $key, OPENSSL_RAW_DATA, '');
        return $str;
    }
}
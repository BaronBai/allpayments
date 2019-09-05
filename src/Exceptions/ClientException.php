<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 16:14
 */

namespace Mzt\AllPayments\Exceptions;


class ClientException extends \Exception
{
    const REQUEST_EXCEPTION = 10001;
    public static function RequestException($msg = ""){
        $msg = $msg ? $msg : "request pay service provider fail !";
        return new self($msg, self::REQUEST_EXCEPTION);
    }
}
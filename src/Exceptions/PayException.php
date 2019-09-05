<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 16:08
 */

namespace Mzt\AllPayments\Exceptions;


class PayException extends \LogicException
{
    const VERIFY_SIGN_FAIL = 50001;
    const NO_SETTING_CONFIG = 40001;
    const PAY_SERVICE_PROVIDER_EXCEPTION = 40002;

    public static function VerifySignFailException(){
        return new self("verify result sign fail !", self::VERIFY_SIGN_FAIL);
    }



    public static function PayServiceProviderException($msg){
        return new self($msg, self::PAY_SERVICE_PROVIDER_EXCEPTION);
    }

    public static function NoSettingConfig(){
        return new self("no setting config!", self::NO_SETTING_CONFIG);
    }
}
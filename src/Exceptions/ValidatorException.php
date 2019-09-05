<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 14:43
 */

namespace Mzt\AllPayments\Exceptions;


class ValidatorException extends \Exception
{
    const PAY_PARAMS_VALIDATION_FAIL = 30001;


    public static function PayParamsValidationFail($msg){
        return new self($msg, self::PAY_PARAMS_VALIDATION_FAIL);
    }


}
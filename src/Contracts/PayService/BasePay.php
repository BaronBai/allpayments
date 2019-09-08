<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 16:23
 */

namespace Mzt\AllPayments\Contracts\PayService;


use Mzt\AllPayments\Exceptions\ValidatorException;

abstract class BasePay extends BasePayService
{

    protected function validParams(array $params){
        $rule = static::paramsRule();
        $validatory = (count($rule) === count($rule,1))
            ? \Mzt\AllPayments\Validator::getInstance()->make($params, $rule)
            : \Mzt\AllPayments\Validator::getInstance()->make($params, ...$rule);

        if ($validatory->fails()) {
            throw ValidatorException::PayParamsValidationFail($validatory->errors()->first());
        }
    }



    abstract protected function paramsRule() : array ;
}
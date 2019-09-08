<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 14:38
 */

namespace Mzt\AllPayments\Contracts\PayService;


use Mzt\AllPayments\Exceptions\ValidatorException;

abstract class BasePayService
{

    /**
     * 关键字段，例如appId,mchId等
     * @var array
     */
    protected $__config = [];



    /**
     * @param array $__config  1维数组或者二维数组
     */
    public function setConfig(array $__config){
        $this->__config = $__config;
    }


    /**
     * @return array
     */
    public function getConfig() : array {
        return $this->__config;
    }

    /**
     * 关键字获取配置
     * @param string $key
     * @return mixed
     */
    public function config(string $key){
        return $this->getConfig()[$key];
    }


    /**
     * 验证配置文件是否符合规则
     * @throws ValidatorException
     */
    protected function validConfig(){
        $rule = static::configRule();
        $params = static::getConfig();

        $validatory = (count($rule) === count($rule,1))
            ? \Mzt\AllPayments\Validator::getInstance()->make($params, $rule)
            : \Mzt\AllPayments\Validator::getInstance()->make($params, ...$rule);

        if ($validatory->fails()) {
            throw ValidatorException::PayParamsValidationFail($validatory->errors()->first());
        }
    }

    /**
     * 配置文件规则
     * @return array
     */
    abstract protected function configRule() : array ;

}
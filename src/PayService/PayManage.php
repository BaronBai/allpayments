<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 19:42
 */

namespace Mzt\AllPayments\PayService;



use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\IWapPay;
use Mzt\AllPayments\Contracts\PayService\BaseNotify;
use Mzt\AllPayments\Contracts\PayService\BasePay;
use Mzt\AllPayments\Contracts\PayService\BasePayService;

/**
 * @method IUnifiedOrder|BasePay unified() 统一下单
 * @method IPayNotify|BaseNotify notifier() 支付回调
 * @method IWapPay|BasePay wap() 手机网页支付
*/
class PayManage
{
    protected $unified;
    protected $notifier;
    protected $wap;


    public function __call($name, $arguments)
    {
        return $this->resolve($name,$arguments);
    }

    public function resolve($method, $arguments){
        $instance =  $this->{$method};
        if (is_null($instance)){
            throw new \Exception("drive not support {$method}");
        }

        return $instance;
    }

    public function setConfig(array $config){
        foreach ($this as $key => $value){
            if ($value instanceof BasePayService){
                $value->setConfig($config);
            }
        }
    }

    /**
     * @param IUnifiedOrder $unified
     */
    public function setUnified($unified): void
    {
        $this->unified = $unified;
    }

    /**
     * @param IPayNotify $notifier
     */
    public function setNotifier($notifier): void
    {
        $this->notifier = $notifier;
    }

    /**
     * @param IWapPay $wap
     */
    public function setWap($wap): void
    {
        $this->wap = $wap;
    }
}
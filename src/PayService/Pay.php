<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/6
 * Time: 0:32
 */

namespace Mzt\AllPayments\PayService;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\IWapPay;
use Mzt\AllPayments\Contracts\PayService\BasePayService;


/**
 * Class Pay
 * @package Mzt\AllPayments\PayService
 */
class Pay
{
    protected $unifiedOrder;
    protected $payNotify;

    public function __construct(IUnifiedOrder $unifiedOrder, IPayNotify $payNotify)
    {
        $this->unifiedOrder = $unifiedOrder;
        $this->payNotify = $payNotify;
    }

    /**
     * @return IUnifiedOrder|BasePayService
     */
    public function unifiedOrder()
    {
        return $this->unifiedOrder;
    }

    /**
     * @return IPayNotify|BasePayService
     */
    public function payNotify()
    {
        return $this->payNotify;
    }
}
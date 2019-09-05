<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 22:32
 */

namespace Mzt\AllPayments\PayService;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\PayService\BasePayService;

class WechatPay
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
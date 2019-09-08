<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 20:13
 */

namespace Mzt\AllPayments\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByJD;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByWechat;
use Mzt\AllPayments\PayService\PayManage;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByJD;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use Mzt\AllPayments\PayService\WapPay\WapPayByAli;

class PayManageServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        "wechatPay",
        "jdPay",
        "aliPay"
    ];

    public function register()
    {
        $this->getLeagueContainer()->add("wechatPay", PayManage::class)
            ->addMethodCall("setUnified",[UnifiedOrderByWechat::class])
            ->addMethodCall("setNotify",[PayNotifyByWechat::class]);


        $this->getLeagueContainer()->add("jdPay", PayManage::class)
            ->addMethodCall("setUnified",[UnifiedOrderByJD::class])
            ->addMethodCall("setNotify",[PayNotifyByJD::class]);


        $this->getLeagueContainer()->add("aliPay", PayManage::class)
            ->addMethodCall("setWapPay",[WapPayByAli::class]);
    }
}
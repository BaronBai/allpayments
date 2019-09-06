<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:17
 */

namespace Mzt\AllPayments\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByWechat;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use Mzt\AllPayments\PayService\WechatPay;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\XmlArray;

class WechatPayServiceProvider extends AbstractServiceProvider
{


    protected $provides = [
        'wechat_pay',
        WechatPay::class,
        UnifiedOrderByWechat::class,
        PayNotifyByWechat::class
    ];



    public function register()
    {

        /**
         * 注册微信支付（统一下单）
         */
        $this->getLeagueContainer()->add(UnifiedOrderByWechat::class)
            ->addArgument(IHttpClient::class)
            ->addArgument(IXml2Array::class)
            ->addArgument(Md5SignUtil::class);




        /**
         * 注册微信支付通知处理类
        */
        $this->getLeagueContainer()->add(PayNotifyByWechat::class)
            ->addArgument(IXml2Array::class)
            ->addArgument(Md5SignUtil::class);



        /**
         * 注册微信支付（聚合所有支付类）
         */
        $this->getLeagueContainer()->add(WechatPay::class)
            ->addArgument(UnifiedOrderByWechat::class)
            ->addArgument(PayNotifyByWechat::class)
            ->setAlias('wechat_pay');

    }
}
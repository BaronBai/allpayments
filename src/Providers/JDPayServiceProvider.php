<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 23:33
 */

namespace Mzt\AllPayments\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByJD;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\PayManage;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByJD;
use Mzt\AllPayments\Utils\JDSignUtil;

class JDPayServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        'jd_pay',
        UnifiedOrderByJD::class,
        PayNotifyByJD::class
    ];

    public function register()
    {
        /**
         * 注册京东支付（统一下单）
         */
        $this->getLeagueContainer()->add(UnifiedOrderByJD::class)
            ->addArgument(IHttpClient::class)
            ->addArgument(JDSignUtil::class);


        /**
         * 注册微信支付通知处理类
         */
        $this->getLeagueContainer()->add(PayNotifyByJD::class)
            ->addArgument(JDSignUtil::class);


        $this->getLeagueContainer()->add('jd_pay',Pay::class)
            ->addArgument(UnifiedOrderByJD::class)
            ->addArgument(PayNotifyByJD::class);


    }
}
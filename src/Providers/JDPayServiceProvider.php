<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 23:33
 */

namespace Mzt\AllPayments\Providers;


use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByJD;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByJD;
use Mzt\AllPayments\Utils\JDSignUtil;

class JDPayServiceProvider implements IServiceProvider
{

    public function boot(Factory $app)
    {

        $callble = function ($app) {
            $service = new Pay(
                $app->make(UnifiedOrderByJD::class),
                $app->make(PayNotifyByJD::class)
            );

            return $service;
        };
        $app->bind('jd',$callble);
    }

    public function register(Factory $app)
    {
        /**
         * 注册京东支付（统一下单）
         */
        $callable = function($app){
            $service = new UnifiedOrderByJD(
                $app->make(IHttpClient::class),
                $app->make(JDSignUtil::class)
            );

            return $service;
        };
        $app->bind(UnifiedOrderByJD::class,$callable);


        /**
         * 注册微信支付通知处理类
         */
        $app->bind(PayNotifyByJD::class,function($app){
            $notify = new PayNotifyByJD(
                $app->make(JDSignUtil::class)
            );

            return $notify;
        });
    }
}
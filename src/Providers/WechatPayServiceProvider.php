<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:17
 */

namespace Mzt\AllPayments\Providers;


use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByWechat;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use Mzt\AllPayments\PayService\WechatPay;
use Mzt\AllPayments\Traits\Md5SignUtil;

class WechatPayServiceProvider implements IServiceProvider
{
    public function boot(Factory $app)
    {

        /**
         * 注册微信支付（聚合所有支付类）
        */
        $callable = function($app){
            $service = new WechatPay(
                $app->make(UnifiedOrderByWechat::class),
                $app->make(PayNotifyByWechat::class)
            );

            return $service;
        };

        $app->bind(WechatPay::class, $callable);
        $app->bind('wechat',$callable);
    }


    public function register(Factory $app)
    {

        /**
         * 注册微信支付（统一下单）
         */
        $callable = function($app){
            $service = new UnifiedOrderByWechat(
                $app->make(IHttpClient::class),
                $app->make(IXml2Array::class),
                $app->make(Md5SignUtil::class)
            );

            return $service;
        };
        $app->bind(UnifiedOrderByWechat::class,$callable);



        /**
         * 注册微信支付通知处理类
        */
        $app->bind(PayNotifyByWechat::class,function($app){
            $notify = new PayNotifyByWechat(
                $app->make(IXml2Array::class),
                $app->make(Md5SignUtil::class)
            );

            return $notify;
        });
    }
}
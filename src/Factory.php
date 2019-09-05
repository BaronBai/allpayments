<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 10:23
 */

namespace Mzt\AllPayments;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Container\Container;
use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\UnifiedOrderByWechat;
use Mzt\AllPayments\PayService\WechatPay;
use Mzt\AllPayments\Providers\HttpServiceProvider;
use Mzt\AllPayments\Providers\JDPayServiceProvider;
use Mzt\AllPayments\Providers\UtilsServiceProvider;
use Mzt\AllPayments\Providers\WechatPayServiceProvider;
use Mzt\AllPayments\Traits\Md5SignUtil;

class Factory extends Container
{

    protected $providers = [
        WechatPayServiceProvider::class,
        UtilsServiceProvider::class,
        HttpServiceProvider::class,
        JDPayServiceProvider::class
    ];


    protected function __construct()
    {
        $this->registerProviders();

    }


    public static function __callStatic($name, $arguments)
    {
        $self = self::getInstance();
        return call_user_func([$self,$name],$arguments);
    }

    protected function registerProviders(){

        $tempProviders = [];

        foreach ($this->providers as $provider){
            /**
             * @var IServiceProvider $instance
             */
            $instance = new $provider;
            $instance->register($this);
            array_push($tempProviders,$instance);
        }

        foreach ($tempProviders as $provider){
            $provider->boot($this);
        }
    }

    /**
     * 获取微信支付聚合类
     * @return WechatPay
    */
    public static function wechat(array $config){
        $self = self::getInstance();

        /**
         * @var WechatPay $wechat
        */
        $wechat = $self->make(WechatPay::class);

        $wechat->unifiedOrder()->setConfig($config);
        return $wechat;
    }
}
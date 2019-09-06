<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 10:23
 */

namespace Mzt\AllPayments;


use League\Container\Container;
use League\Container\Definition\DefinitionAggregateInterface;
use League\Container\Inflector\InflectorAggregateInterface;
use League\Container\ServiceProvider\ServiceProviderAggregateInterface;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\WechatPay;
use Mzt\AllPayments\Providers\HttpServiceProvider;
use Mzt\AllPayments\Providers\JDPayServiceProvider;
use Mzt\AllPayments\Providers\UtilsServiceProvider;
use Mzt\AllPayments\Providers\WechatPayServiceProvider;

class Factory extends Container
{

    protected $serviceProviders = [
        UtilsServiceProvider::class,
        HttpServiceProvider::class,
        WechatPayServiceProvider::class,
        JDPayServiceProvider::class
    ];

    public function __construct(
        ?DefinitionAggregateInterface $definitions = null,
        ?ServiceProviderAggregateInterface $providers = null,
        ?InflectorAggregateInterface $inflectors = null
    ) {
        parent::__construct($definitions, $providers, $inflectors);
        $this->registerProviders();
    }




    protected function registerProviders(){
        foreach ($this->serviceProviders as $provider){
            $this->addServiceProvider($provider);
        }
    }

    /**
     * 获取微信支付聚合类
     * @return WechatPay
    */
    public static function wechat(array $config){
        $instance = new self();

        /**
         * @var WechatPay $wechatInstance
        */
        $wechatInstance = $instance->get('wechat_pay');
        $wechatInstance->unifiedOrder()->setConfig($config);
        $wechatInstance->payNotify()->setConfig($config);
        return $wechatInstance;
    }


    public static function jd(array $config){
        $instance = new self();

        /**
         * @var Pay $jd
         */
        $jd = $instance->get('jd_pay');
        $jd->unifiedOrder()->setConfig($config);
        $jd->payNotify()->setConfig($config);
        return $jd;
    }
}
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
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\JDPay;
use Mzt\AllPayments\PayService\UnifiedOrder\JDResponseHandle;
use Mzt\AllPayments\Utils\JDSignUtil;

class JDPayServiceProvider implements IServiceProvider
{

    public function boot(Factory $app)
    {
        $callble = function($app) {
            $service = new JDPay(
                $app->make(BaseHttpClient::class),
                $app->make(JDSignUtil::class),
                $app->make(JDResponseHandle::class)
            );

            return $service;
        };

        $app->bind(JDPay::class,$callble);
        $app->bind('jd',$callble);
    }

    public function register(Factory $app)
    {
        $app->bind(JDResponseHandle::class,function($app){
            $service = new JDResponseHandle(
                $app->make(JDSignUtil::class)
            );

            return $service;
        });
    }
}
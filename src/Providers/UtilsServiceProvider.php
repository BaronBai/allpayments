<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:24
 */

namespace Mzt\AllPayments\Providers;


use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\XmlArray;

class UtilsServiceProvider implements IServiceProvider
{

    public function register(Factory $app)
    {
        $app->bind(IXml2Array::class,XmlArray::class);
        $app->bind('md5Sign',Md5SignUtil::class);
        $app->bind(ISignUtil::class, Md5SignUtil::class);
    }

    public function boot(Factory $app)
    {
        // TODO: Implement boot() method.
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:24
 */

namespace Mzt\AllPayments\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\Utils\JDSignUtil;
use Mzt\AllPayments\XmlArray;

class UtilsServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        IXml2Array::class,
        ISignUtil::class,
        Md5SignUtil::class,
        JDSignUtil::class
    ];

    public function register()
    {
        $this->getContainer()->add(IXml2Array::class, XmlArray::class);
        $this->getContainer()->add(ISignUtil::class,Md5SignUtil::class);
        $this->getContainer()->add(Md5SignUtil::class);
        $this->getContainer()->add(JDSignUtil::class);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 22:43
 */

namespace Mzt\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\WechatPay;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    public function testMakeWechat(){
        $wechat = Factory::wechat([
            'appid' => 'your app id',
            'mch_id' => 'your mch id',
            'key' => 'your key'
        ]);
        $this->assertInstanceOf(WechatPay::class, $wechat);
        $this->assertInstanceOf(IUnifiedOrder::class,$wechat->unifiedOrder());
        $this->assertInstanceOf(IPayNotify::class,$wechat->payNotify());
    }


    public function testMakeJD(){
        $jd = Factory::jd([
            '3desKey' => 'your config',
            'merchantNo' => 'your config',
            'md5Key' => 'your config',
            'systemId' => 'your config'
        ]);
        $this->assertInstanceOf(Pay::class, $jd);
        $this->assertInstanceOf(IUnifiedOrder::class,$jd->unifiedOrder());
        $this->assertInstanceOf(IPayNotify::class,$jd->payNotify());
    }
}
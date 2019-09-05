<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 22:43
 */

namespace Mzt\Tests;


use Mzt\AllPayments\Factory;
use Mzt\AllPayments\PayService\WechatPay;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    public function testMakeWechat(){
        $wechat = Factory::wechat();
        $this->assertInstanceOf(WechatPay::class, $wechat);
    }
}
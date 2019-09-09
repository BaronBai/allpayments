<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 19:44
 */

namespace Mzt\Tests;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\IWapPay;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\PayService\PayManage;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use PHPUnit\Framework\TestCase;

class PayManageTest extends TestCase
{
    public function testResolveFail(){
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("drive not support unified");
        $pay = new PayManage();
        $pay->unified();
    }


    public function testSetCall(){
        $pay = new PayManage();

        $unified = (new Factory())->get(UnifiedOrderByWechat::class);
        $pay->setUnified($unified);

        $instance = $pay->unified();
        $this->assertInstanceOf(IUnifiedOrder::class,$instance);
    }

    public function testResolveWechatPayManage(){
        /**
         * @var PayManage $pay;
         */
        $pay = (new Factory())->get('wechatPay');
        $this->assertInstanceOf(IUnifiedOrder::class, $pay->unified());
        $this->assertInstanceOf(IPayNotify::class,$pay->notifier());
    }


    public function testResolveJDPayManage(){
        /**
         * @var PayManage $pay;
         */
        $pay = (new Factory())->get('jdPay');
        $this->assertInstanceOf(IUnifiedOrder::class, $pay->unified());
        $this->assertInstanceOf(IPayNotify::class,$pay->notifier());
    }

    public function testResolveAliPayManage(){
        /**
         * @var PayManage $pay;
        */
        $pay = (new Factory())->get('aliPay');
        $this->assertInstanceOf(IWapPay::class, $pay->wap());
    }
}
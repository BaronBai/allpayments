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
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\WechatPay;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{


//    public function testContainer(){
//        $factory = new Factory();
//        $factory->add(ClientInterface::class, Client::class);
//
////        $factory->add(BaseHttpClient::class)
////            ->addArgument(ClientInterface::class);
//
//        $factory->add(IHttpClient::class, BaseHttpClient::class)
//            ->addArgument(ClientInterface::class);
//
//        $instance = $factory->get(IHttpClient::class);
//
//        $this->assertInstanceOf(BaseHttpClient::class,$instance);
//
//        // BaseHttpClient 是 IHttpClient的实现
//        // BaseHttpClient 的构造函数依赖ClientInterface的实现
//        // 按照代码顺序
//        // 1. DI 注册 ClientInterface的实现为 Client.class
//        // 2. DI 注册 BaseHttpClient，并且在构造函数注入 ClientInterface的实现
//        // 3. DI 注册 IHttpClient的实现 为BaseHttpClient
//        //--------------------------------------------------------------------------
//        // 我认为，理论上我现在需要一个 IHttpClient 的实现，DI 会 自己去递归解决依赖吧。
//        // 1. 在 注册树 中找到 IHttpClient的实现
//        // 2. IHttpClient的实现是 BaseHttpClient
//        // 3. 查找注册树中有没有 注册 BaseHttpClient
//        // 4. 发现有注册，并且发现构造函数还有依赖
//        // 5. 再去注册树中查找 BaseHttpClient的构造函数的依赖
//        // 6. 实例化 BaseHttpClient 构造函数的 依赖
//        // 7. 实例化 BaseHttpClient
//        // 8. 返回BaseHttpClient给我
//    }


    public function testMakeWechat(){
        $wechat = Factory::wechat([
            'appid' => 'your app id',
            'mch_id' => 'your mch id',
            'key' => 'your key'
        ]);
        $this->assertInstanceOf(WechatPay::class, $wechat);
    }


    public function testMakeJD(){
        $jd = Factory::jd([
            '3desKey' => 'your config',
            'merchantNo' => 'your config',
            'md5Key' => 'your config',
            'systemId' => 'your config'
        ]);
        $this->assertInstanceOf(Pay::class, $jd);
    }
}
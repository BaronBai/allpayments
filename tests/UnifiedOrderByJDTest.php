<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 17:30
 */

namespace Mzt\Tests;


use GuzzleHttp\Client;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByJD;
use Mzt\AllPayments\Utils\JDSignUtil;
use PHPUnit\Framework\TestCase;

class UnifiedOrderByJDTest extends TestCase
{
    /**
     * @var UnifiedOrderByJD $client
     */
    protected $client;


    public function setUp()
    {
        parent::setUp();
        $dir = dirname(__FILE__);
        $this->dirName = $dir;

        $httpClient = new BaseHttpClient(new Client());
        $signUtil = new JDSignUtil();
        $client = new UnifiedOrderByJD($httpClient,$signUtil);
        $client->setConfig([
            '3desKey' => $_ENV['JD_DES_KEY'],
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'md5Key' => $_ENV['JD_MD5_KEY'],
            'systemId' => $_ENV['JD_SYSTEM_ID']
        ]);
        $this->client = $client;
    }


    public function testWxPayNoOpenID(){

        $this->expectException(ValidatorException::class);
        $this->expectExceptionCode(30001);

        $orderSN = "sdk".date('YmdHis');

        $this->client->unify([
            'amount' => 1,
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'outTradeNo' => $orderSN,
            'outTradeIp' => '127.0.0.1',
            'productName' => '测试商品支付',
            'piType' => 'WX',
            'gatewayPayMethod' => 'SUBSCRIPTION',
            'deviceInfo' => json_encode([
                'type' => 'DT02',
                'imei' => 'aaasaasasasasdad'
            ],JSON_UNESCAPED_UNICODE),
        ]);
    }


    public function testWxPaySuccess(){

        $orderSN = "sdk".date('YmdHis');

        $result = $this->client->unify([
            'amount' => 1,
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'outTradeNo' => $orderSN,
            'outTradeIp' => '127.0.0.1',
            'productName' => '测试商品支付',
            'piType' => 'WX',
            'gatewayPayMethod' => 'SUBSCRIPTION',
            'notifyUrl' => 'http://localhost',
            'deviceInfo' => json_encode([
                'type' => 'DT02',
                'imei' => 'aaasaasasasasdad'
            ],JSON_UNESCAPED_UNICODE),
            'openId' => 'ogbn-1Rsf1uHB6PVYSucT8VNl8zM'
        ]);

        $this->assertArrayHasKey('payInfo',$result);
    }


    public function testAliPaySuccess(){

        $orderSN = "sdk".date('YmdHis');

        $result = $this->client->unify([
            'amount' => 1,
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'outTradeNo' => $orderSN,
            'outTradeIp' => '127.0.0.1',
            'productName' => '测试商品支付',
            'piType' => 'ALIPAY',
            'notifyUrl' => 'http://localhost',
            'gatewayPayMethod' => 'SUBSCRIPTION',
            'deviceInfo' => json_encode([
                'type' => 'DT02',
                'imei' => 'aaasaasasasasdad'
            ],JSON_UNESCAPED_UNICODE),
            'openId' => '2088702200635151'
        ]);

        $this->assertArrayHasKey('payInfo',$result);
    }


    public function testJDSuccess(){

        $orderSN = "sdk".date('YmdHis');

        $result = $this->client->unify([
            'amount' => 1,
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'outTradeNo' => $orderSN,
            'outTradeIp' => '127.0.0.1',
            'productName' => '测试商品支付',
            'piType' => 'JDPAY',
            'notifyUrl' => 'http://localhost',
            'gatewayPayMethod' => 'SUBSCRIPTION',
            'deviceInfo' => json_encode([
                'type' => 'DT02',
                'imei' => 'aaasaasasasasdad'
            ],JSON_UNESCAPED_UNICODE)
        ]);

        $this->assertArrayHasKey('payInfo',$result);
    }
}
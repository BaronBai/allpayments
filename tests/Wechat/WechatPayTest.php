<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 16:16
 */

namespace Mzt\Tests\Wechat;

use GuzzleHttp\Client;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\XmlArray;
use PHPUnit\Framework\TestCase;

class WechatPayTest extends TestCase
{


    /**
     * @var UnifiedOrderByWechat $wechat
    */
    protected $wechat;

    protected function setUp()
    {
        parent::setUp();
        $httpClient = new BaseHttpClient(new Client());
        $xmlArray = new XmlArray();
        $signUtil = new Md5SignUtil();
        $service = new UnifiedOrderByWechat($httpClient,$xmlArray,$signUtil);
        $service->setConfig([
            'appid' => $_ENV['WECHAT_APP_ID'],
            'mch_id' => $_ENV['WECHAT_MCH_NO'],
            'key' => $_ENV['WECHAT_KEY']
        ]);
        $this->wechat = $service;
    }


    public function testUnifyWapPay(){
        $params = [
            'total_fee' => 1,
            'body' => '测试Wap支付',
            'out_trade_no' => 'sdk'.date('YmdHis'),
            'spbill_create_ip' => '127.0.0.1',
            'notify_url' => 'http://localhost',
            'trade_type' => 'MWEB',
            'scene_info' => json_encode([
                'h5_info' => 'h5_info',
                'type' => 'mall',
                'wap_url' => 'http://localhost',
                'wap_name' => '测试商城'
            ])
        ];


        $result = $this->wechat->unify($params);
        $this->assertArrayHasKey('mweb_url',$result);
    }



    public function testUnifyJsPay(){
        $params = [
            'total_fee' => 1,
            'body' => '测试Wap支付',
            'out_trade_no' => 'sdk'.date('YmdHis'),
            'spbill_create_ip' => '127.0.0.1',
            'notify_url' => 'http://localhost',
            'trade_type' => 'JSAPI',
            'openid' => $_ENV['WECHAT_OPENID']
        ];



        $result = $this->wechat->unify($params);
        $this->assertArrayHasKey('prepay_id',$result);
    }
}
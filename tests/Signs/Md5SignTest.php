<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 21:33
 */

namespace Mzt\Tests\Signs;


use Mzt\AllPayments\Traits\Md5SignUtil;
use PHPUnit\Framework\TestCase;

class Md5SignTest extends TestCase
{
    protected $sign = 'C725091E57F0358A5B7E68DF07C9B531';
    protected $key = '123123123';
    protected $failKey = '123123123a';

    protected $params = [
        'appid' => '12l1lqlwe',
        'attach' => '123987aeqoiu',
        'body' => '测试',
        'mch_id' => '123o123123',
        'nonce_str' => '123wqweiqueo',
        'out_trade_no' => '1231qweqwe',
        'spbill_create_ip' => '127.0.0.1',
        'total_fee' => 12
    ];


    // 测试样本数据来自微信官方调试工具 https://pay.weixin.qq.com/wiki/tools/signverify/
    public function testSign(){
        //测试签名不匹配
        $signUtil = new Md5SignUtil();
        $sign1 = $signUtil->sign($this->params,$this->failKey);
        $this->assertNotEquals($sign1,$this->sign);

        //测试签名匹配
        $sign2 = $signUtil->sign($this->params,$this->key);
        $this->assertEquals($sign2,$this->sign);
    }

    public function testVerifySign(){
        $signUtil = new Md5SignUtil();
        $b = $signUtil->verifySign($this->params,$this->key,$this->sign);
        $this->assertTrue($b);
    }
}
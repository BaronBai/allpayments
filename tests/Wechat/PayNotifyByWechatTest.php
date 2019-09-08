<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 20:32
 */

namespace Mzt\Tests\Wechat;

use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByWechat;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\XmlArray;
use PHPUnit\Framework\TestCase;

class PayNotifyByWechatTest extends TestCase
{


    /**
     * @var IPayNotify $client
    */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $notify = new PayNotifyByWechat(
            new XmlArray(),
            new Md5SignUtil()
        );
        $notify->setConfig([
            'appid' => $_ENV['WECHAT_APP_ID'],
            'mch_id' => $_ENV['WECHAT_MCH_NO'],
            'key' => $_ENV['WECHAT_KEY']
        ]);
        $this->client = $notify;
    }


    public function testNotifyByVerifySignFail()
    {
        $this->expectException(PayException::class);
        $this->expectExceptionCode(50001);

        $content = mockResponse(TEMP_DIR.'/wechat_pay_notify.xml')->getBody()->getContents();
        $this->client->notify($content,function($content){
            return true;
        });
    }

    public function testNotifyBySuccess(){
        $this->expectException(PayException::class);
        $this->expectExceptionCode(50001);

        $content = mockResponse(TEMP_DIR.'/wechat_pay_notify.xml')->getBody()->getContents();
        $response = $this->client->notify($content,function($content){
            return true;
        });


        $temp = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";

        $xml = $response->getContent();
        $this->assertEquals($temp,$xml);
    }
}

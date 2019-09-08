<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 21:22
 */

namespace Mzt\Tests\JD;

use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\PayService\Notifys\PayNotifyByJD;
use Mzt\AllPayments\Utils\JDSignUtil;
use PHPUnit\Framework\TestCase;

class PayNotifyByJDTest extends TestCase
{
    /**
     * @var IPayNotify $client
     */
    protected $client;


    public function setUp()
    {
        parent::setUp();
        $client = new PayNotifyByJD(
            new JDSignUtil()
        );

        $client->setConfig([
            '3desKey' => $_ENV['JD_DES_KEY'],
            'merchantNo' => $_ENV['JD_MCH_NO'],
            'md5Key' => $_ENV['JD_MD5_KEY'],
            'systemId' => $_ENV['JD_SYSTEM_ID']
        ]);
        $this->client = $client;
    }

    /**
     * @expectedException Mzt\AllPayments\Exceptions\PayException
     * @expectedExceptionCode 40002
     */
    public function testPayExceptionBySuccessToFalse(){
        $resource = mockResponse(TEMP_DIR.'/jd.response/success_to_false.json');
        $content = $resource->getBody()->getContents();
        $this->client->notify($content, function($content){
            return true;
        });
    }

    /**
     * @expectedException Mzt\AllPayments\Exceptions\PayException
     * @expectedExceptionCode 50001
     */
    public function testPayExceptionBySignFail(){

        $resource = mockResponse(TEMP_DIR.'/jd.response/sign_fail.json');
        $content = $resource->getBody()->getContents();
        $this->client->notify($content, function($content){
            return true;
        });

    }

    public function testSuccess(){

        $resource = mockResponse(TEMP_DIR.'/jd.response/sign_success.json');
        $content = $resource->getBody()->getContents();
        $response = $this->client->notify($content, function($content){
            return true;
        });

        $this->assertEquals('ok',$response->getContent());
    }
}

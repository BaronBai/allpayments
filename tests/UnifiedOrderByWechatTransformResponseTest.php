<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 14:33
 */

namespace Mzt\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByWechat;
use Mzt\AllPayments\Traits\Md5SignUtil;
use Mzt\AllPayments\XmlArray;
use PHPUnit\Framework\TestCase;



class UnifiedOrderByWechatTransformResponseTest extends TestCase
{

    protected $dirName;

    protected $secret = [
        'appid' => 'wx2421b1c4370ec43b',
        'mch_id' => '10000100',
        'key' => 'aaaaa1cs13644lyybjb2v8d2kj82222'
    ];

    /**
     * @var UnifiedOrderByWechat $client
    */
    protected $client;


    public function setUp()
    {
        parent::setUp();
        $dir = dirname(__FILE__);
        $this->dirName = $dir;

        $httpClient = new BaseHttpClient(new Client());
        $xmlArray = new XmlArray();
        $signUtil = new Md5SignUtil();
        $service = new UnifiedOrderByWechat($httpClient,$xmlArray,$signUtil);
        $service->setConfig($this->secret);
        $this->client = $service;
    }

    protected function mockResponse(string $xmlFileName){
        $resource = fopen($this->dirName.$xmlFileName,'r+');
        $steram = new Stream($resource);
        $response = new Response(200,[],$steram);
        return $response;
    }



    public function testPayExceptionByReturnCodeFail(){
        $this->expectException(PayException::class);
        $this->expectExceptionCode(40002);

        $response = $this->mockResponse("/temp/wechat_pay_fail_response.xml");
        $this->client->transformResponse($response);

        $this->fail("Failed to assert transformResponse throw exception with 40002.");
    }


    public function testPayExceptionByResultCodeFail(){
        $this->expectException(PayException::class);
        $this->expectExceptionCode(40002);

        $response = $this->mockResponse("/temp/wechat_pay_fail_response2.xml");
        $this->client->transformResponse($response);

        $this->fail("Failed to assert transformResponse throw exception with 40002.");

    }


    public function testPayExceptionByVerifySignFail(){
        $this->expectException(PayException::class);
        $this->expectExceptionCode(50001);

        $response = $this->mockResponse("/temp/wechat_pay_response_sign_fail.xml");
        $this->client->transformResponse($response);
        $this->fail("Failed to assert transformResponse throw exception with 50001.");
    }



    public function testSuccess(){
        $response = $this->mockResponse("/temp/wechat_pay_response_sign_success.xml");
        $result = $this->client->transformResponse($response);
        $this->assertArrayHasKey('appid', $result);
    }
}
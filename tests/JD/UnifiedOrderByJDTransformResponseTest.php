<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 23:39
 */

namespace Mzt\Tests\JD;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Mzt\AllPayments\Http\BaseHttpClient;
use Mzt\AllPayments\PayService\UnifiedOrder\UnifiedOrderByJD;
use Mzt\AllPayments\Utils\JDSignUtil;
use PHPUnit\Framework\TestCase;

class UnifiedOrderByJDTransformResponseTest extends TestCase
{
    protected $dirName;



    /**
     * @var UnifiedOrderByJD $client
    */
    protected $client;


    public function setUp()
    {
        parent::setUp();

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


    /**
     * @expectedException Mzt\AllPayments\Exceptions\PayException
     * @expectedExceptionCode 40002
     */
    public function testPayExceptionBySuccessToFalse(){
        $response = mockResponse(TEMP_DIR.'/jd.response/success_to_false.json');
        $this->client->transformResponse($response);
    }

    /**
     * @expectedException Mzt\AllPayments\Exceptions\PayException
     * @expectedExceptionCode 50001
     */
    public function testPayExceptionBySignFail(){
        $response = mockResponse(TEMP_DIR.'/jd.response/sign_fail.json');
        $this->client->transformResponse($response);
    }

    public function testSuccess(){
        $response = mockResponse(TEMP_DIR.'/jd.response/sign_success.json');
        $result = $this->client->transformResponse($response);
        $this->assertArrayHasKey('payInfo',$result);
    }
}
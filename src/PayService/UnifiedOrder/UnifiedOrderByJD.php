<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/4
 * Time: 17:23
 */

namespace Mzt\AllPayments\PayService\UnifiedOrder;


use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\ITransform;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\PayService\BasePayService;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Mzt\AllPayments\Utils\TDESUtil;
use Mzt\AllPayments\Validator;
use Psr\Http\Message\ResponseInterface;

class UnifiedOrderByJD extends BasePayService implements IUnifiedOrder, ITransform
{
    const API_URI = "https://apipayx.jd.com/m/unifiedOrder";

    protected $fixedParams = [
        'currency' => 'RMB',
        'version' => 'V3.0',
        'businessCode' => 'AGGRE',
    ];

    protected $client;
    protected $signUtil;

    public function __construct(IHttpClient $client, ISignUtil $signUtil)
    {
        $this->client = $client;
        $this->signUtil = $signUtil;
    }

    protected function configRule(): array
    {
        return [
            '3desKey' => 'required|string',
            'md5Key' => 'required|string',
            'systemId' => 'required|string',
            'merchantNo' => 'required|string'
        ];
    }

    public function unify(array $params): array
    {
        $this->validConfig($this->getConfig());
        $this->validParams($params);

        $params = array_merge($params,$this->fixedParams);

        $desKey = $this->config('3desKey');
        $encryptData = $this->encryptData($params,$desKey);
        $sign = $this->signUtil->sign($params,$this->config('md5Key'));

        $mchNO = $this->config('merchantNo');
        $systemId = $this->config('systemId');
        $postData = json_encode([
            'merchantNo' => $mchNO,
            'systemId' => $systemId,
            'cipherJson' => $encryptData,
            'sign' => $sign
        ],JSON_UNESCAPED_UNICODE);

        $response = $this->client->postJson(self::API_URI,$postData);

        return $this->transformResponse($response);
    }

    public function transformResponse(ResponseInterface $response): array
    {
        $result = $response->getBody()->getContents();
        $resultData = json_decode($result,true);

        if ($resultData['success'] !== true){
            throw PayException::PayServiceProviderException("发起支付失败，原因是：{$resultData['errCodeDes']}");
        }
        $desKey = $this->config('3desKey');
        $deEncryptText = TDESUtil::decrypt($resultData['cipherJson'],$desKey);
        $deEncryptData = json_decode($deEncryptText,true);

        $verifyResult = $this->signUtil->verifySign($deEncryptData, $this->config('md5Key'),$resultData['sign']);

        if ($verifyResult !== true){
            throw PayException::VerifySignFailException();
        }

        if ($deEncryptData['resultCode'] !== 'SUCCESS') {
            throw PayException::PayServiceProviderException("发起支付失败2，原因是：{$deEncryptData['errCodeDes']}");
        }

        return $deEncryptData;
    }


    protected function validParams(array $params){
        $b = Validator::validators($params,[
            'amount' => 'required|integer',
            'outTradeNo' => 'required|string',
            'outTradeIp' => 'required|string',
            'productName' => 'required|string',
            'piType' => 'required|string|in:WX,ALIPAY,JDPAY,UNIPAY',
            'gatewayPayMethod' => 'required|string|in:MINIPROGRAM,SUBSCRIPTION',
            'deviceInfo' => 'required|string',
            'openId' => 'required_unless:piType,JDPAY'
        ]);

        if (!$b) {
            throw ValidatorException::PayParamsValidationFail(\Mzt\AllPayments\Validator::getMessage());
        }
    }

    protected function encryptData(array &$params, $key){
        ksort($params);
        $jsonData = json_encode($params,JSON_UNESCAPED_UNICODE);
        $encryptData = TDESUtil::encrypt($jsonData,$key);
        return $encryptData;
    }
}
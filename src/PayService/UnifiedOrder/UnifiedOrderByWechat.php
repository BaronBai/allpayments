<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 13:44
 */

namespace Mzt\AllPayments\PayService\UnifiedOrder;

use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\ITransform;
use Mzt\AllPayments\Contracts\IUnifiedOrder;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Contracts\PayService\BasePay;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Mzt\AllPayments\Traits\StringsUtils;
use Psr\Http\Message\ResponseInterface;

class UnifiedOrderByWechat extends BasePay implements IUnifiedOrder, ITransform
{

    use StringsUtils;

    const API_URI = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    protected $client;
    protected $xml2Array;
    protected $signUtil;

    public function __construct(
        IHttpClient $client,
        IXml2Array $xml2Array,
        ISignUtil $signUtil
    ) {
        $this->client = $client;
        $this->xml2Array = $xml2Array;
        $this->signUtil = $signUtil;
    }

    protected function configRule(): array
    {
        return [
            [
                'appid' => 'required|string',
                'mch_id' => 'required|string',
                'key' => 'required|string'
            ],
            [
                'appid.required' => 'appid 参数缺失',
                'mch_id.required' => 'mch_id 参数缺失',
                'key.required' => 'key 参数缺失'
            ]
        ];
    }

    protected function paramsRule(): array
    {
        return [
            'body' => 'required|string',
            'out_trade_no' => 'required|string',
            'total_fee' => 'required|integer',
            'spbill_create_ip' => 'required|string',
            'notify_url' => 'required|string',
            'trade_type' => 'required|in:MWEB,JSAPI,APP,NATIVE',
            'openid' => 'required_if:trade_type,JSAPI|string',
            'scene_info' => 'required_if:trade_type,MWEB|string'
        ];
    }


    public function unify(array $options): array
    {

        $this->validConfig();
        $this->validParams($options);

        $secretParams = $this->extractSecretParams($this->getConfig());

        $options['nonce_str'] = $this->randomString();
        $params = array_merge($options,$secretParams);
        $params['sign'] = $this->signUtil->sign($params,$this->config('key'));

        $postXml = $this->xml2Array->toXml($params);

        $response = $this->client->postXml(self::API_URI, $postXml);

        return $this->transformResponse($response);

    }


    public function transformResponse(ResponseInterface $response) : array {

        $resultXml = $response->getBody()->getContents();
        $result = $this->xml2Array->toArray($resultXml);

        if ($result['return_code'] !== 'SUCCESS') {
            throw PayException::PayServiceProviderException($result['return_msg']);
        }

        if ($result['result_code'] !== 'SUCCESS') {
            throw PayException::PayServiceProviderException($result['err_code_des'] .
                "\n 错误码是：" . $result['err_code']);
        }

        if (!$this->signUtil->verifySign($result, $this->config('key'),$result['sign'])) {
            throw PayException::VerifySignFailException();
        }

        return $result;
    }


    protected function extractSecretParams(array $secret): array
    {
        return [
            'appid' => $secret['appid'],
            'mch_id' => $secret['mch_id']
        ];
    }



//    protected function validParams(array $params)
//    {
//        $b = \Mzt\AllPayments\Validator::validators($params, [
//            'body' => 'required|string',
//            'out_trade_no' => 'required|string',
//            'total_fee' => 'required|integer',
//            'spbill_create_ip' => 'required|string',
//            'notify_url' => 'required|string',
//            'trade_type' => 'required|in:MWEB,JSAPI,APP,NATIVE',
//            'openid' => 'required_if:trade_type,JSAPI|string',
//            'scene_info' => 'required_if:trade_type,MWEB|string'
//        ], [
//            'scene_info.required_if' => 'h5支付必须要传递scene_info字段',
//            'openid.required_if' => 'js、小程序支付必须要传递openid字段'
//        ]);
//
//        if (!$b) {
//            throw ValidatorException::PayParamsValidationFail(\Mzt\AllPayments\Validator::getMessage());
//        }
//    }
}
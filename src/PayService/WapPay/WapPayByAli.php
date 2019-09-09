<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/6
 * Time: 23:52
 */

namespace Mzt\AllPayments\PayService\WapPay;


use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\IWapPay;
use Mzt\AllPayments\Contracts\PayService\BasePay;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WapPayByAli extends BasePay implements IWapPay
{

    protected $fixedParams = [
        'method' => 'alipay.trade.wap.pay',
        'charset' => 'utf-8',
        'sign_type' => 'RSA2',
        'version' => '1.0'
    ];


    protected $bizContentFixedParams = [
        'product_code' => 'QUICK_WAP_WAY'
    ];


    protected $signUtil;

    public function __construct(ISignUtil $signUtil)
    {
        $this->signUtil = $signUtil;
    }


    protected function configRule(): array
    {
        return [
            'app_id' => 'required|string',
            'private_key' => 'required|string',
        ];
    }

    protected function paramsRule(): array
    {
        return [
            'notify_url' => 'required|string',
            'biz_content.subject' => 'required|string',
            'biz_content.out_trade_no' => 'required|string',
            'biz_content.total_amount' => 'required|integer',
        ];
    }


    protected function urlencodeParams(array &$params) : array {
        foreach ($params as $key => $value){
            $params[$key] = urlencode($value);
        }

        return $params;
    }


    public function wapPay(array $params) : RedirectResponse
    {
        $this->validConfig();
        $this->validParams($params);

        $bizContent = array_merge($params['biz_content'],$this->bizContentFixedParams);
        $params['biz_content'] = json_encode($bizContent,JSON_UNESCAPED_UNICODE);
        $params = array_merge($params,$this->fixedParams);
        $params['app_id'] = $this->config('app_id');
        $params['timestamp'] = date('Y-m-d H:i:s');

        $sign = $this->signUtil->sign($params,$this->config('private_key'));
        $params['sign'] = $sign;
        $response = new RedirectResponse(ALI_API_GATEWAY.'?'.http_build_query($params));
        return $response;
    }
}
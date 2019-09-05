<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 18:21
 */

namespace Mzt\AllPayments\PayService\Notifys;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\IXml2Array;
use Mzt\AllPayments\Contracts\PayService\BaseNotify;
use Mzt\AllPayments\Contracts\PayService\BasePayService;
use Mzt\AllPayments\Exceptions\PayException;
use Symfony\Component\HttpFoundation\Response;

class PayNotifyByWechat extends BasePayService implements IPayNotify
{

    protected $xmlUtil;
    protected $signUtil;

    public function __construct(IXml2Array $xml2Array, ISignUtil $signUtil)
    {
        $this->xmlUtil = $xml2Array;
        $this->signUtil = $signUtil;
    }


    protected function configRule(): array
    {
        return [
            'appid' => 'required|string',
            'mch_id' => 'required|string',
            'key' => 'required|string'
        ];
    }

    public function notify(string $content, callable $callback): Response
    {
        $this->validConfig($this->getConfig());
        $response = new Response();
        $data = $this->xmlUtil->toArray($content);

        if ($data['return_code'] !== 'SUCCESS'){
            throw PayException::PayServiceProviderException("微信支付通知异常，错误信息是：{$data['return_msg']}");
        }

        if ($data['result_code'] !== 'SUCCESS'){
            throw PayException::PayServiceProviderException("微信支付通知异常，错误信息是：{$data['err_code_des']}".
                "\n 错误码是：" . $data['err_code']);
        }

        if (!$this->signUtil->verifySign($data, $this->config('key'),$data['sign'])) {
            throw PayException::VerifySignFailException();
        }

        $b = call_user_func($callback,$content);
        if ($b === true){
            $result = [
                'return_code' => 'SUCCESS',
                'return_msg' => 'OK'
            ];

            $xml = $this->xmlUtil->toXml($result);
            $response->setContent($xml);
        }

        return $response;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 21:00
 */

namespace Mzt\AllPayments\PayService\Notifys;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\PayService\BasePayService;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Utils\TDESUtil;
use Symfony\Component\HttpFoundation\Response;

class PayNotifyByJD extends BasePayService implements IPayNotify
{

    protected $signUtil;

    public function __construct(ISignUtil $signUtil)
    {
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

    public function notify(string $content, callable $callback): Response
    {
        $params = json_decode($content,true);
        if ($params['success'] !== true){
            throw PayException::PayServiceProviderException("支付通知异常, success is not true");
        }

        $deEncryptText = TDESUtil::decrypt($params['cipherJson'],$this->config('3desKey'));
        $deEncryptData = json_decode($deEncryptText,true);
        $verifyResult = $this->signUtil->verifySign($deEncryptData,$this->config('md5Key'),$params['sign']);
        if ($verifyResult !== true){
            throw PayException::VerifySignFailException();
        }

        if ($deEncryptData['resultCode'] !== 'SUCCESS') {
            throw PayException::PayServiceProviderException("支付通知失败，原因是：{$deEncryptData['errCodeDes']}");
        }

        $b = call_user_func($callback,$deEncryptData);

        return $b
            ? new Response("ok")
            : new Response("no");
    }
}
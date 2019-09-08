<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 22:33
 */

namespace Mzt\AllPayments\PayService\Notifys;


use Mzt\AllPayments\Contracts\IPayNotify;
use Mzt\AllPayments\Contracts\ISignUtil;
use Mzt\AllPayments\Contracts\PayService\BaseNotify;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class PayNotifyByAli extends BaseNotify implements IPayNotify
{

    protected $signUtil;
    public function __construct(ISignUtil $signUtil)
    {
        $this->signUtil = $signUtil;
    }

    protected function configRule(): array
    {
        return [
            'app_id' => 'required|string',
            'ali_public_key' => 'required|string'
        ];
    }

    public function notify(string $content, callable $callback): Response
    {
        $this->validConfig();
        $response = new Response();

        $content = urldecode($content);
        $params = json_decode($content);
        $sign = $params['sign'];
        $signType = $params['sign_type'];
        unset($params['sign']);
        unset($params['sign_type']);

        $b = $this->signUtil->verifySign($params,$this->config('ali_public_key'),$sign);

        if (!$b){
            throw PayException::VerifySignFailException();
        }

        $callbackResult = call_user_func($callback,$params);

        if ($callbackResult === true){
            $response->setContent("success");
        }

        return $response;
    }

}
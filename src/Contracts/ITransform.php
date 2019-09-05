<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 18:27
 */

namespace Mzt\AllPayments\Contracts;


use Psr\Http\Message\ResponseInterface;

interface ITransform
{
    /**
     * 验证支付服务商返回内容是否合法，并处理成对用户友好的数据返回
     * @param ResponseInterface $response
     * @return array
     */
    public function transformResponse(ResponseInterface $response) : array;
}
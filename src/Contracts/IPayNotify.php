<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 18:20
 */

namespace Mzt\AllPayments\Contracts;


use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

interface IPayNotify
{


    /**
     * @param string $content
     * @param callable $callback
     * @throws ValidatorException
     * @throws PayException
     * @return Response
     */
    public function notify(string $content , callable $callback) : Response;

}
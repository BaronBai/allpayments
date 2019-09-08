<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/6
 * Time: 23:51
 */

namespace Mzt\AllPayments\Contracts;


use Mzt\AllPayments\Exceptions\ClientException;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface IWapPay
{


    /**
     * @param array $params
     * @throws ValidatorException
     * @throws PayException
     * @throws ClientException
     * @return RedirectResponse
     */
    public function wapPay(array $params) : RedirectResponse;
}
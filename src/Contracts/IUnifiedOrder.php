<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 14:09
 */

namespace Mzt\AllPayments\Contracts;



use Mzt\AllPayments\Exceptions\ClientException;
use Mzt\AllPayments\Exceptions\PayException;
use Mzt\AllPayments\Exceptions\ValidatorException;

interface IUnifiedOrder
{


    /**
     * @param array $params
     * @throws ValidatorException
     * @throws PayException
     * @throws ClientException
     * @return array
     */
    public function unify(array $params) : array ;

}
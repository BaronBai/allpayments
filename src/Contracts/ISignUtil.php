<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 10:35
 */

namespace Mzt\AllPayments\Contracts;


interface ISignUtil
{
    public function sign(array $data, string $key) : string ;

    public function verifySign(array $data, string $key, string $sign = '') : bool ;
}
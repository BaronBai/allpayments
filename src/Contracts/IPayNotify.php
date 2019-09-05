<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/5
 * Time: 18:20
 */

namespace Mzt\AllPayments\Contracts;


use Symfony\Component\HttpFoundation\Response;

interface IPayNotify
{
    public function notify(string $content , callable $callback) : Response;

}
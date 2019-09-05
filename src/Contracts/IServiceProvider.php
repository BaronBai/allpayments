<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:16
 */

namespace Mzt\AllPayments\Contracts;


use Mzt\AllPayments\Factory;

interface IServiceProvider
{
    public function register(Factory $app);


    public function boot(Factory $app);
}
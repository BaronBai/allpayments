<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 14:09
 */

namespace Mzt\AllPayments\Contracts;



interface IUnifiedOrder
{
    public function unify(array $params) : array ;

}
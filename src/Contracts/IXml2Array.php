<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 9:55
 */

namespace Mzt\AllPayments\Contracts;


interface IXml2Array
{
    public function toArray(string $xml) : array ;


    public function toXml(array $arr) : string ;
}
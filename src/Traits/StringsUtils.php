<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/2
 * Time: 15:30
 */

namespace Mzt\AllPayments\Traits;


trait StringsUtils
{
    public function randomString(){
        $random = rand(100000,99999999);
        $result = dechex($random);
        return substr($result,0,64);
    }
}
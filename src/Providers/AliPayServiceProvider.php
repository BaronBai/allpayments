<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 15:32
 */

namespace Mzt\AllPayments\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\PayService\Pay;
use Mzt\AllPayments\PayService\WapPay\WapPayByAli;
use Mzt\AllPayments\Utils\Signs\RSA2Sign;

class AliPayServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        WapPayByAli::class
    ];

    public function register()
    {
        $this->getLeagueContainer()->add(WapPayByAli::class)
            ->addArgument(RSA2Sign::class);
    }

}
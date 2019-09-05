<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 16:39
 */

namespace Mzt\AllPayments\Providers;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Contracts\IServiceProvider;
use Mzt\AllPayments\Factory;
use Mzt\AllPayments\Http\BaseHttpClient;

class HttpServiceProvider implements IServiceProvider
{

    public function register(Factory $app)
    {
        $app->bind(ClientInterface::class,Client::class);
        $app->bind(IHttpClient::class, BaseHttpClient::class);
    }

    public function boot(Factory $app)
    {
        // TODO: Implement boot() method.
    }
}
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
use League\Container\ServiceProvider\AbstractServiceProvider;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Http\BaseHttpClient;

class HttpServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        ClientInterface::class,
        IHttpClient::class,
    ];


    public function register()
    {
        $this->getLeagueContainer()->add(ClientInterface::class, Client::class);

        $this->getLeagueContainer()->add(IHttpClient::class, BaseHttpClient::class)
            ->addArgument(ClientInterface::class);


    }


}
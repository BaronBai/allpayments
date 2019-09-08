<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 15:11
 */

namespace Mzt\AllPayments\Contracts;


use Psr\Http\Message\ResponseInterface;

interface IHttpClient
{
    public function request(string $uri, string $method = 'GET', array $options = []) : ResponseInterface;

    public function postXml(string $uri, $body) : ResponseInterface;

    public function postJson(string $uri, string $body) : ResponseInterface;
}
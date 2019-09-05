<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/3
 * Time: 15:12
 */

namespace Mzt\AllPayments\Http;


use GuzzleHttp\ClientInterface;
use Mzt\AllPayments\Contracts\IHttpClient;
use Mzt\AllPayments\Exceptions\ClientException;
use Psr\Http\Message\ResponseInterface;

class BaseHttpClient implements IHttpClient
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function request(string $uri, string $method = 'GET', array $options = []) : ResponseInterface
    {
        $method = strtolower($method);
        try {
            $response = $this->client->request($method, $uri, $options);
            return $response;
        } catch (\Exception $e) {
            throw ClientException::RequestException($e->getMessage());
        }
    }


    public function postXml(string $uri, $body): ResponseInterface
    {
        try {
            $response = $this->client->request('post',$uri,
                [
                    'headers' => [
                        'Content-type' => 'text/xml'
                    ],
                    'body' => $body
                ]);
            return $response;
        } catch (\Exception $e) {
            throw ClientException::RequestException($e->getMessage());
        }
    }


    public function postJson(string $uri, $body): ResponseInterface
    {
        try {
            $response = $this->client->request('post',$uri,
                [
                    'headers' => [
                        'Content-type' => 'application/json;charset=utf-8'
                    ],
                    'body' => $body
                ]);
            return $response;
        } catch (\Exception $e) {
            throw ClientException::RequestException($e->getMessage());
        }
    }
}
<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

require_once ("./vendor/autoload.php");

$jdSecret = [
    '3desKey' => $_ENV['JD_DES_KEY'],
    'merchantNo' => $_ENV['JD_MCH_NO'],
    'md5Key' => $_ENV['JD_MD5_KEY'],
    'systemId' => $_ENV['JD_SYSTEM_ID']
];

function mockResponse(string $xmlFileName){
    $resource = fopen($xmlFileName,'r+');
    $steram = new Stream($resource);
    $response = new Response(200,[],$steram);
    return $response;
}
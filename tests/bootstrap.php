<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

require_once("./vendor/autoload.php");

const TEMP_DIR = __DIR__.'/temp';

function mockResponse(string $xmlFileName){
    $resource = fopen($xmlFileName,'r+');
    $steram = new Stream($resource);
    $response = new Response(200,[],$steram);
    return $response;
}
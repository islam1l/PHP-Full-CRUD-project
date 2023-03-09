<?php

use GuzzleHttp\Client;

require "vendor/autoload.php";

//use app\Email;
//use app\Person;
//
//$email = new Email();
//$person = new Person();

$client = new Client();
$response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

echo $response->getStatusCode(). "<br>"; // 200

echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$client = new Edofre\BolCom\Client('YOURAPIKEYGOESHERE');
$ping = $client->ping();

var_dump($ping);

// 1002004010708531 = inception
$product = $client->product('1002004010708531', [
    'type'              => 'raw',
    'offers'            => 'all',
    'includeattributes' => true,
]);

var_dump($product);

// 123 does not exist
$unknownProduct = $client->product('123', [
    'type'              => 'raw',
    'offers'            => 'all',
    'includeattributes' => true,
]);

var_dump($unknownProduct);
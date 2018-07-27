<?php

// Useful for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$client = new Edofre\BolCom\Client('YOURAPIKEYGOESHERE!');
$ping = $client->ping();

var_dump($ping);
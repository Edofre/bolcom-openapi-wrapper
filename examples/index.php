<?php

// Let's show some errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Make sure you installed the package
require __DIR__ . '/vendor/autoload.php';

// Create the client with your API key
$client = new Edofre\BolCom\Client('YOURAPIKEYGOESHERE');

/*
|--------------------------------------------------------------------------
| Ping
|--------------------------------------------------------------------------
*/
try {
    $ping = $client->ping();
    var_dump($ping);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

/*
|--------------------------------------------------------------------------
| Products
| 1002004010708531 = inception
| 123 does not exist
|--------------------------------------------------------------------------
*/
try {
    $product = $client->product('1002004010708531', [
        'type'              => 'raw',
        'offers'            => 'all',
        'includeattributes' => true,
    ]);
    var_dump($product);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

try {
    $unknownProduct = $client->product('123', [
        'type'              => 'raw',
        'offers'            => 'all',
        'includeattributes' => true,
    ]);
    var_dump($unknownProduct);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

/*
|--------------------------------------------------------------------------
| Recommendations
| 1002004010708531 = inception
| 123 does not exist
|--------------------------------------------------------------------------
*/
try {
    $recommendations = $client->recommendations('1002004010708531', [
        'includeattributes' => true,
        //        'offers' => 'all',
        'limit' => 10, // Max is 20
        'offset' => 0,
        'country' => 'NL',
    ]);
    var_dump($recommendations);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

/*
|--------------------------------------------------------------------------
| Related Products
| 1002004010708531 = inception
| 123 does not exist
|--------------------------------------------------------------------------
*/
try {
    $relatedProducts = $client->relatedProducts('1002004010708531', [
        'dataset' => 'productfamily,accessories',
        'country' => 'NL',
    ]);
    var_dump($relatedProducts);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

/*
|--------------------------------------------------------------------------
| Offers
| 1002004010708531 = inception
|--------------------------------------------------------------------------
*/
try {
    $offers = $client->offers('1002004010708531', [
        // 'offers' => 'all,cheapest,secondhand,newoffers,bolcom',
        'offers'  => 'cheapest', // Default
        'country' => 'NL',
    ]);
    var_dump($offers);
} catch (Exception $e) {
    var_dump($e);
    exit;
}
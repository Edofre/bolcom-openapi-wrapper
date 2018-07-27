<?php

namespace Edofre\BolCom;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 * @package Edofre\BolCom
 */
class Client
{
    /** @var string API URL */
    const API_URL = 'https://api.bol.com';
    /** @var string API version, used in requests */
    const API_VERSION = 'v4';

    /** Endpoints */
    const ENDPOINT_CATEGORY_UTILITIES = 'utils';

    const ENDPOINT_PING = 'ping';
    /** @var \GuzzleHttp\Client */
    private $client;


    /**
     * NsApi constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new GuzzleClient(array_merge([
            'base_uri' => self::API_URL,
        ], $config));
    }


    public function ping(array $options = [])
    {
        $response = $this->client->get($this->getFullEndpoint(self::ENDPOINT_PING), $options);

        var_dump($response);
        exit;
    }

    private function getFullEndpoint($category, $endpoint)
    {
        var_dump($category);
        var_dump($endpoint);
        exit;

    }

}
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

    /** @var string */
    const ENDPOINT_CATEGORY_UTILITIES = 'utils';
    /** @var string */
    const ENDPOINT_PING = 'ping';

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var array */
    private $options = [
        'query' => ['apikey' => ''],
    ];

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct($apikey, array $config = [])
    {
        $this->client = new GuzzleClient(array_merge([
            'base_uri' => self::API_URL,
        ], $config));

        // TODO, some checking for a valid key

        $this->options['query']['apikey'] = $apikey;
    }

    /**
     * @return mixed
     */
    public function ping()
    {
        $response = $this->client->get(
            $this->getFullEndpoint(self::ENDPOINT_CATEGORY_UTILITIES, self::ENDPOINT_PING),
            ['query' => $this->options['query']]
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * @param        $category
     * @param        $endpoint
     * @param string $version
     * @return string
     */
    private function getFullEndpoint($category, $endpoint, $version = self::API_VERSION)
    {
        return "/{$category}/{$version}/{$endpoint}";
    }
}
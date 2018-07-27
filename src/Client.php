<?php

namespace Edofre\BolCom;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

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

        $this->options['query']['apikey'] = $apikey;
    }

    /**
     * @param array $options
     */
    public function ping()
    {
        try {
            $response = $this->client->get(
                $this->getFullEndpoint(self::ENDPOINT_CATEGORY_UTILITIES, self::ENDPOINT_PING),
                ['query' => $this->options['query']]
            );
            var_dump($response);

        } catch (ClientException $clientException) {
            var_dump($clientException->getMessage());
            var_dump($clientException);
            exit;
        }


    }

    /**
     * @param $category
     * @param $endpoint
     * @return string
     */
    private function getFullEndpoint($category, $endpoint, $version = self::API_VERSION)
    {
        return "/{$category}/{$version}/{$endpoint}";
    }
}
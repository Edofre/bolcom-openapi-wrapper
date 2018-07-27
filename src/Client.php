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
    const ENDPOINT_CATEGORY_CATALOG = 'catalog';
    /** @var string */
    const ENDPOINT_PING = 'ping';
    const ENDPOINT_PRODUCTS = 'products';

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var array */
    private $options = [
        'apikey' => '',
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

        $this->options['apikey'] = $apikey;
    }

    /**
     * @return mixed
     */
    public function ping()
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_UTILITIES,
            self::API_VERSION,
            self::ENDPOINT_PING,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions();

        $response = $this->client->get(
            $url,
            $query
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * @param        $category
     * @param        $endpoint
     * @param string $version
     * @return string
     */
    private function buildUrl($items)
    {
        return implode('/', $items);
    }

    /**
     * @param array $options
     * @return array
     */
    private function buildQueryOptions(array $options = [])
    {
        return ['query' => array_merge($this->options, $options)];
    }

    /**
     * @param        $id
     * @param string $queryParams
     * @return mixed
     */
    public function product($id, $queryParams = '')
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_PRODUCTS,
            $id,
        ]);
        //  'type' => string 'raw' (length=3)
        //  includeattributes = true  and offers = all

        $query = ['query' => $this->options['query']];
        var_dump($query);

        $response = $this->client->get(
            $url,
            $query
        );

        return json_decode($response->getBody(), true);

    }
}
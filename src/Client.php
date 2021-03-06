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
    const ENDPOINT_RECOMMENDATIONS = 'recommendations';
    const ENDPOINT_RELATED_PRODUCTS = 'relatedproducts';
    const ENDPOINT_OFFERS = 'offers';
    const ENDPOINT_LISTS = 'lists';
    /** @var string */
    const COUNTRY_NETHERLANDS = 'NL';
    const COUNTRY_BELGIUM = 'BE';

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var array */
    private $queryOptions = [
        'apikey' => '',
    ];

    /** @var array Options for offer query parameter */
    private $offerOptions = [
        'all',
        'bestoffer', // Default
        'cheapest',
        'secondhand',
        'newoffers',
        'bolcom',
    ];

    /**
     * @var array
     */
    private $countryOptions = [
        self::COUNTRY_NETHERLANDS,
        self::COUNTRY_BELGIUM,
    ];

    /**
     * Client constructor.
     * @param string $apiKey
     * @param array  $config
     */
    public function __construct($apiKey, array $config = [])
    {
        $this->client = new GuzzleClient(array_merge([
            'base_uri' => self::API_URL,
        ], $config));

        // TODO, some checking for a valid key?
        $this->queryOptions['apikey'] = $apiKey;
    }

    /**
     * @return mixed
     * @throws \Exception
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
     * @param $items
     * @return string
     */
    private function buildUrl($items)
    {
        return implode('/', $items);
    }

    /**
     * @param array $queryOptions
     * @return array
     * @throws \Exception
     */
    private function buildQueryOptions(array $queryOptions = [])
    {
        $mergedOptions = array_merge($this->queryOptions, $queryOptions);

        // Check if offers key correct
        if (isset($mergedOptions['offers'])) {
            // Check for validity
            if (!in_array($mergedOptions['offers'], $this->offerOptions)) {
                throw new \Exception("Offer option: '{$mergedOptions['offers']}' is not supported.");
            }
        }

        return ['query' => $mergedOptions];
    }

    /**
     * @param        $id
     * @param array  $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function product($id, array $queryParams = [])
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_PRODUCTS,
            $id,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions($queryParams);

        // Make the call
        $response = $this->client->get(
            $url,
            $query
        );

        // Return the first entry of the products key
        return json_decode($response->getBody(), true)['products'][0];
    }

    /**
     * @param       $id
     * @param array $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function recommendations($id, array $queryParams = [])
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_RECOMMENDATIONS,
            $id,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions($queryParams);

        // Make the call
        $response = $this->client->get(
            $url,
            $query
        );

        return json_decode($response->getBody(), true)['products'];
    }

    /**
     * @param       $id
     * @param array $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function relatedProducts($id, array $queryParams = [])
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_RELATED_PRODUCTS,
            $id,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions($queryParams);

        // Make the call
        $response = $this->client->get(
            $url,
            $query
        );

        return json_decode($response->getBody(), true);
    }

    /**
     * @param       $id
     * @param array $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function offers($id, array $queryParams = [])
    {
        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_OFFERS,
            $id,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions($queryParams);

        // Make the call
        $response = $this->client->get(
            $url,
            $query
        );

        return json_decode($response->getBody(), true);
    }

    /**
     * @param        $type
     * @param        $ids
     * @param        $offset
     * @param        $limit
     * @param        $sort
     * @param        $sortingAscending
     * @param        $includeProducts
     * @param        $includeCategories
     * @param        $includeRefinements
     * @param bool   $includeAttributes
     * @param string $listId
     * @return mixed
     * @throws \Exception
     */
    public function lists($type, $ids, $offset, $limit, $sort, $sortingAscending, $includeProducts, $includeCategories, $includeRefinements, $includeAttributes = false, $listId = '')
    {
        $queryParams = [];

        if (!empty($type)) {
            $queryParams['type'] = urlencode($type);
        }
        if (!empty($q)) {
            $queryParams['q'] = urlencode($q);
        }
        if (!empty($ids)) {
            $queryParams['ids'] = urlencode($ids);
        }
        if (!empty($includeAttributes)) {
            $queryParams['includeattributes'] = urlencode($includeAttributes);
        }
        if (!empty($offset)) {
            $queryParams['offset'] = urlencode($offset);
        }
        if (!empty($limit)) {
            $queryParams['limit'] = urlencode($limit);
        }
        if (!empty($sort) && !empty($sortingAscending)) {
            $queryParams['sort'] = urlencode($sort);
            $queryParams['sortingAscending'] = (($sortingAscending) ? 'true' : 'false');
        }
        if (!empty($offers)) {
            $queryParams['offers'] = urlencode($offers);
        }
        if (!empty($searchfield)) {
            $queryParams['searchfield'] = urlencode($searchfield);
        }
        if (!empty($pids)) {
            $queryParams['pids'] = urlencode($pids);
        }

        $dataOutput = '';
        if (!empty($includeProducts)) {
            $dataOutput .= 'products,';
        }
        if (!empty($includeCategories)) {
            $dataOutput .= 'categories,';
        }
        if (!empty($includeRefinements)) {
            $dataOutput .= 'refinements,';
        }

        $queryParams['dataoutput'] = $dataOutput;

        // Build the URL
        $url = $this->buildUrl([
            self::ENDPOINT_CATEGORY_CATALOG,
            self::API_VERSION,
            self::ENDPOINT_LISTS,
            $ids,
        ]);

        // Build the query options
        $query = $this->buildQueryOptions($queryParams);

        // Make the call
        $response = $this->client->get(
            $url,
            $query
        );

        return json_decode($response->getBody(), true);
    }
}
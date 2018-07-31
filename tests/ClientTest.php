<?php

use Edofre\BolCom\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 */
class ClientTest extends TestCase
{
    /** @var Edofre\BolCom\Client */
    protected $client;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = new Client(getenv('API_KEY'));
    }

    /** @test */
    public function apiKey()
    {
        $message =
            "We need your API_KEY to be configured in order to run tests!\n\n" .
            "Run phpunit like this:\n" .
            "API_KEY=YOUR_API_KEY phpunit\n" .
            "or add your API_KEY to phpunit.xml\n";

        $this->assertNotEquals('YOUR_API_KEY', getenv('API_KEY'), $message);
    }

    /** @test */
    public function getPing()
    {
        $response = $this->client->ping();

        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Hello world!', $response['message']);
    }

    /** @test */
    public function getProduct()
    {
        // 9200000091193302 == octopath traveler
        $productId = '9200000091193302';
        $response = $this->client->product($productId);

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($response['id'], $productId);
        $this->assertArrayHasKey('ean', $response);
        $this->assertEquals($response['ean'], '0045496422165');
    }
}

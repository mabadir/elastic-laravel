<?php

namespace MAbadir\ElasticLaravel\Tests\Unit;

use GuzzleHttp\Exception\RequestException;
use Tests\TestCase;
use Elasticsearch\Client as ElasticClient;
use Elasticsearch\ClientBuilder;
use MAbadir\ElasticLaravel\ElasticClient as Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ElasticLaravelIndexUnitTest extends TestCase
{
    protected $host = 'http://localhost:9200/';
    protected $index = 'test_index';
    protected $client;

    public function setUp()
    {
        parent::setUp();
        try{
            $this->request('DELETE', '?pretty');
        }catch (\Exception $e){}

        $this->client = new Client();
    }

    /** @test */
    public function can_create_index_on_elastic_search()
    {
        $params = [];
        $this->client->createIndex($params);

        $response = $this->request('GET','');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey($this->index, json_decode($response->getBody()->getContents(),true));
    }

    /** @test */
    public function can_drop_an_existing_index_on_elastic_search()
    {
        $params = [];
        $this->client->createIndex($params);

        $response = $this->request('GET','');
        $this->assertEquals(200, $response->getStatusCode());

        $this->client->dropIndex($params);
        try{
            $response = $this->request('GET','');
        }
        catch(RequestException $e)
        {
            $this->assertEquals(404,$e->getResponse()->getStatusCode());
        }
    }

    /**
     * Create HTTP request with the $method
     * to $url using $body
     *
     * @param       $method
     * @param       $url
     * @param array $body
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function request($method, $url, $body=[])
    {
        $guzzle = new \GuzzleHttp\Client(['base_uri' => $this->host.$this->index]);
        return $guzzle->request($method, $url, $body);
    }
}

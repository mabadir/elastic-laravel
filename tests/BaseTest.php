<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/21/17
 * Time: 12:53 PM
 */

namespace MAbadir\ElasticLaravel\Tests;

use Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use Elasticsearch\Client as ElasticClient;
use MAbadir\ElasticLaravel\ElasticClient as Client;

class BaseTest extends TestCase
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
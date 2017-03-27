<?php

namespace MAbadir\ElasticLaravel\Tests\Unit;

use GuzzleHttp\Exception\RequestException;
use MAbadir\ElasticLaravel\Tests\BaseTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ElasticLaravelIndexUnitTest extends BaseTest
{
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
        $this->client->createIndex();

        $response = $this->request('GET','');
        $this->assertEquals(200, $response->getStatusCode());

        $this->client->dropIndex();
        try{
            $response = $this->request('GET','');
        }
        catch(RequestException $e)
        {
            $this->assertEquals(404,$e->getResponse()->getStatusCode());
        }
    }

}

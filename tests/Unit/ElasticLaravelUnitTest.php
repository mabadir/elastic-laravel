<?php

namespace MAbadir\ElasticLaravel\Tests\Unit;

use Elasticsearch\Client as ElasticClient;
use MAbadir\ElasticLaravel\Tests\BaseTest;
use MAbadir\ElasticLaravel\ElasticClient as Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ElasticLaravelUnitTest extends BaseTest
{
    /** @test */
    public function can_connect_to_elastic_search_instance()
    {
        $this->assertInstanceOf(ElasticClient::class, $this->client->getClient());
    }

    /** @test */
    public function can_index_to_elastic_search_index()
    {
        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [ 'testField' => 'abc']
        ];

        $this->client->index($params);

        $response = $this->request('GET',$this->index.'/my_type/my_id');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('_source', json_decode($response->getBody()->getContents(),true));
    }

    /** @test */
    public function can_update_a_document_to_elastic_search()
    {
        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [ 'testField' => 'abc']
        ];
        $this->client->index($params);
        $response = $this->request('GET',$this->index.'/my_type/my_id');
        $this->assertContains('abc', json_decode($response->getBody()->getContents(),true));

        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [
                'doc' => [
                    'testField' => 'new value'
                ]
             ]
        ];
        $this->client = new Client();
        $this->client->update($params);


        $response = $this->request('GET',$this->index.'/my_type/my_id');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('new value', json_decode($response->getBody()->getContents(),true));
    }

    /** @test */
    public function can_delete_a_document_from_elastic_search()
    {
        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [ 'testField' => 'abc']
        ];
        $this->client->index($params);
        $response = $this->request('GET',$this->index.'/my_type/my_id');
        $this->assertContains('abc', json_decode($response->getBody()->getContents(),true));

        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
        ];
        $this->client = new Client();
        $this->client->delete($params);

        try{
            $response = $this->request('GET',$this->index.'/my_type/my_id');
        }
        catch(\Exception $e)
        {
            $this->assertEquals(404,$e->getResponse()->getStatusCode());
        }
    }

    /** @test */
    public function can_ge_a_document_from_elastic_search()
    {
        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [ 'testField' => 'abc']
        ];
        $this->client->index($params);
        $response = $this->request('GET',$this->index.'/my_type/my_id');
        $this->assertContains('abc', json_decode($response->getBody()->getContents(),true));

        $params = [
            'type' => 'my_type',
            'id' => 'my_id',
        ];
        $result = $this->client->get($params);
        $this->assertArrayHasKey('_source', $result);
    }

}

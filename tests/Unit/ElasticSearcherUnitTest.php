<?php

namespace MAbadir\ElasticLaravel\Tests\Unit;

use App\User;
use MAbadir\ElasticLaravel\ElasticSearcher;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MAbadir\ElasticLaravel\Tests\BaseTest;

class ElasticSearcherUnitTest extends BaseTest
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $params = [
            "body" => [
                "mappings" => [
                    "users" => [
                        "properties" => [
                            "id" => [
                                "type" => "integer",
                                "index" => "no"
                            ],
                            "created_at" => [
                                "type" => "date",
                                "format" => "yyyy-MM-dd HH:mm:ss"
                            ],
                            "name" => [
                                "type" => "text",
                                "analyzer" => "simple"
                            ],
                            "email" => [
                                "type" => "text",
                                "index" => "not_analyzed",
                            ],
                            "updated_at" => [
                                "type" => "date",
                                "format" => "yyyy-MM-dd HH:mm:ss"
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->client->createIndex($params);

        $this->user = factory(User::class)->create([
            'name' => 'Mina',
            'email' => 'mina.youssef@gmail.com'
        ]);

        $params = [
            'type' => 'users',
            'id' => $this->user->id,
        ];
        $result = $this->client->get($params);
        $this->assertArrayHasKey('_source', $result);
    }

    /** @test */
    public function can_search_index_for_specific_term()
    {
        $results = ElasticSearcher::search($this->user->name);
        $this->assertContains('Mina',$results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_for_a_term_on_specific_type()
    {
        $results = ElasticSearcher::search($this->user->name, $this->user);
        $this->assertContains('Mina',$results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_for_specific_attribute()
    {
        $results = ElasticSearcher::search(['name' => $this->user->name], $this->user);
        $this->assertContains('Mina',$results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_using_advanced_search()
    {
        $params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ];
        $results = ElasticSearcher::advanced($params);
        $this->assertContains('Mina', $results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_using_advanced_search_on_specific_type()
    {
        $params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ];
        $results = ElasticSearcher::advanced($params, $this->user);
        $this->assertContains('Mina', $results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_using_advanced_search_with_json()
    {
        json_encode($params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ]);
        $results = ElasticSearcher::advanced($params);
        $this->assertContains('Mina', $results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_search_index_using_advanced_search_on_specific_type_using_json()
    {
        json_encode($params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ]);
        $results = ElasticSearcher::advanced($params, $this->user);
        $this->assertContains('Mina', $results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function can_accept_class_name_instead_of_object()
    {
        json_encode($params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ]);
        $results = ElasticSearcher::advanced($params, User::class);
        $this->assertContains('Mina', $results['hits']['hits'][0]['_source']);
    }

    /** @test */
    public function object_must_be_a_valid_eloquent_model()
    {
        json_encode($params = [
            'match' => [
                '_all' => 'Mina'
            ]
        ]);
        $this->expectException(\MAbadir\ElasticLaravel\Exceptions\NotValidEloquentException::class);
        $results = ElasticSearcher::advanced($params, (new \StdClass()) );
    }
}

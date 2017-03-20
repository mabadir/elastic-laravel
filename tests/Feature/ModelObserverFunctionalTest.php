<?php

namespace MAbadir\ElasticLaravel\Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use MAbadir\ElasticLaravel\Jobs\IndexModel;
use MAbadir\ElasticLaravel\ElasticClient as Client;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModelObserverFunctionalTest extends TestCase
{
    use DatabaseMigrations;

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
    public function model_observer_dispatches_creation_job_when_model_is_created()
    {
        Bus::fake();

        $u = factory(User::class)->create();
        $u->save();

        Bus::assertDispatched(IndexModel::class, function($job) use ($u){
           return $job->model->id === $u->id && $job->operation == 'index';
        });
    }

    /** @test */
    public function model_observer_dispatches_index_job_when_model_is_updated()
    {

        $u = factory(User::class)->create();
        $u->save();

        $u->name = 'New Name';
        Bus::fake();
        $u->save();
        Bus::assertDispatched(IndexModel::class, function($job) use ($u){
            return $job->model->id === $u->id && $job->operation == 'update' ;
        });
    }

    /** @test */
    public function model_observer_dispatches_index_job_when_model_is_deleted()
    {
        $u = factory(User::class)->create();
        $u->save();

        Bus::fake();
        $u->delete();
        Bus::assertDispatched(IndexModel::class, function($job) use ($u){
            return $job->model->id === $u->id && $job->operation == 'delete' ;
        });
    }

    /** @test */
    public function model_is_indexed_to_elastic_search_after_creation()
    {
        $u = factory(User::class)->create();
        $u->save();

        $response = $this->request('GET','/test_index/users/'.$u->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains($u->name, json_decode($response->getBody()->getContents(),true));
    }

    /** @test */
    public function model_is_indexed_to_elastic_search_after_update()
    {
        $u = factory(User::class)->create();
        $u->save();

        $u->name = ' New Name';
        $u->save();

        $response = $this->request('GET','/test_index/users/'.$u->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('New Name', json_decode($response->getBody()->getContents(),true));
    }

    /** @test */
    public function model_is_removed_from_elastic_search_after_delete()
    {
        $u = factory(User::class)->create();
        $id = $u->id;

        User::destroy($id);

        try{
            $response = $this->request('GET','/test_index/users/'.$id);
        }
        catch(\Exception $e)
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
        $guzzle = new \GuzzleHttp\Client(['base_uri' => $this->host]);
        return $guzzle->request($method, $url, $body);
    }
}

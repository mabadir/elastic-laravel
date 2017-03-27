<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/17/17
 * Time: 2:20 AM
 */

namespace MAbadir\ElasticLaravel;
use Elasticsearch\ClientBuilder as Elastic;

class ElasticClient
{
    protected $index, $params, $client;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->params = [
            'index' => config('elastic.index')
        ];

        $hosts = [
            [
                'host' => config('elastic.host'),
                'port' => config('elastic.port'),
//            'scheme' => 'https',
//            'user' => 'username',
//            'pass' => 'password!#$?*abc'
            ]
        ];

        $this->client = Elastic::create()           // Instantiate a new ClientBuilder
                                ->setHosts($hosts)      // Set the hosts
                                ->build();
    }

    /**
     * Merges Parameters received by client with index parameter
     *
     * @param $params
     *
     * @return array
     */
    protected function mergeParams($params)
    {
        return $this->params + $params;
    }

    /**
     * Returns the Elastic Search Client instance
     * @return \Elasticsearch\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Creates the index with the given $params settings
     *
     * @param $params
     *
     * @return array
     */
    public function createIndex($params = [])
    {
        return $this->client->indices()->create($this->mergeParams($params));
    }

    /**
     * Drops the index with the given $params settings
     *
     * @param $params
     *
     * @return array
     */
    public function dropIndex($params = [])
    {
        return $this->client->indices()->delete($this->mergeParams($params));
    }

    /**
     * Indexes a document of the given parameters
     *
     * @param $params
     *
     * @return array
     */
    public function index($params)
    {
        return $this->client->index($this->mergeParams($params));
    }

    /**
     * Retrieves a document of the given parameters
     *
     * @param $params
     *
     * @return array
     */
    public function get($params)
    {
        return $this->client->get($this->mergeParams($params));
    }

    /**
     * Updates a document of the given parameters
     *
     * @param $params
     *
     * @return array
     */
    public function update($params)
    {
        return $this->client->update($this->mergeParams($params));
    }

    /**
     * Deletes a document of the given parameters
     *
     * @param $params
     *
     * @return array
     */
    public function delete($params)
    {
        return $this->client->delete($this->mergeParams($params));
    }

    /**
     * Searches the index with the given params
     *
     * @param $params
     *
     * @return array
     */
    public function search($params)
    {
        return $this->client->search($this->mergeParams($params));
    }
}
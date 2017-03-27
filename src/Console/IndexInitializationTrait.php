<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/26/17
 * Time: 3:38 PM
 */

namespace MAbadir\ElasticLaravel\Console;

use MAbadir\ElasticLaravel\ElasticClient;

trait IndexInitializationTrait
{
    /**
     * Basic standard configuration
     * @var array
     */
    protected $params = [
        "body" => [
            "settings" => [
                "number_of_shards" => 1,
                "number_of_replicas" => 0,
            ],
        ],
    ];

    /**
     * Holds the ElasticClient
     * @var \MAbadir\ElasticLaravel\ElasticClient
     */
    protected $client;

    /**
     * IndexInitializationTrait constructor.
     *
     * @param \MAbadir\ElasticLaravel\ElasticClient $client
     */
    public function __construct(ElasticClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Are you sure you want to proceed, this will destroy the Search Index? [y|N]'))
        {
            return $this->confirmPassword();
        }
    }

    /**
     * Confirms user awareness before proceeding
     *
     * @return    mixed
     * @author    Mina Abadir <mina@abadir.email>
     * @copyright Copyright (c) 2016, Mina Abadir
     */
    protected function confirmPassword()
    {
        $password = str_random(7);
        $input = $this->ask('For safety please enter this text "'.$password.'"');
        if($input == $password){
            return $this->buildIndex();
        }
        else {
            return $this->error('Password is incorrect!');
        }
    }

    /**
     * Deletes, Creates the Index then puts the settings
     *
     * @return    mixed
     * @author    Mina Abadir <mina@abadir.email>
     * @copyright Copyright (c) 2016, Mina Abadir
     */
    protected function buildIndex()
    {
        $this->client->dropIndex();
        $response = $this->client->createIndex($this->params);

        if(is_array($response) && $response['acknowledged'] == true)
        {
            $this->info('Index Initialization Successful');
        }
        else{
            $this->error('Index Initialization Failed');
        }
    }
}
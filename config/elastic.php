<?php

return [
    //ElasticSearch host
    'host' => env('ELASTIC_SEARCH_HOST', 'localhost'),

    //ElasticSearch port
    'port' => env('ELASTIC_SEARCH_PORT', 9200),

    //ElasticSearch Index
    'index' => env('ELASTIC_SEARCH_INDEX')
];

<?php

namespace MAbadir\ElasticLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use MAbadir\ElasticLaravel\ElasticClient;

class IndexModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model, $params, $operation;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $params, $operation)
    {
        $this->model = $model;
        $this->params = $params;
        $this->operation = $operation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new ElasticClient();
        $client->{$this->operation}($this->params);
    }
}

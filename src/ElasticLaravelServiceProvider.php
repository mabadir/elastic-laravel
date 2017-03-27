<?php

namespace MAbadir\ElasticLaravel;

use Illuminate\Support\ServiceProvider;
use MAbadir\ElasticLaravel\Console\Commands\ElasticIndexer;

class ElasticLaravelServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/elastic.php' => config_path('elastic.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ElasticIndexer::class
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
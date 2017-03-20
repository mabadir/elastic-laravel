<?php

namespace MAbadir\ElasticLaravel;

use Illuminate\Support\ServiceProvider;

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
            __DIR__.'../config/elastic.php' => config_path('elastic.php'),
        ]);

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
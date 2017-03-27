<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/26/17
 * Time: 3:50 PM
 */

namespace MAbadir\ElasticLaravel\Console\Commands;

use Illuminate\Console\Command;
use MAbadir\ElasticLaravel\Console\IndexInitializationTrait;

class ElasticIndexer extends Command
{
    use IndexInitializationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize ElasticSearch Index';
}
<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/17/17
 * Time: 2:07 AM
 */

namespace MAbadir\ElasticLaravel;

use MAbadir\ElasticLaravel\Observers\ModelObserver;

trait ElasticEloquent
{
    /**
     * Model Boot method
     */
    public static function bootElasticEloquent()
    {
        static::observe(ModelObserver::class);
    }

    /**
     * Returns the type used to index models on Elastic Search
     * @return string
     */
    public function getIndexType()
    {
        return $this->getTable();
    }

    /**
     * Returns the id used to index models on Elastic Search
     * @return string
     */
    public function getIndexId()
    {
        return $this->getKey();
    }

    /**
     * Returns the different parameters to be indexed
     * @return mixed
     */
    public function getSearchableIndex()
    {
        return $this->toArray();
    }

    /**
     * Returns the DB name
     * @return mixed
     */
    public abstract function getTable();

    /**
     * Returns the model primary key
     * @return mixed
     */
    public abstract function getKey();
}
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
        return strtolower(str_plural(class_basename($this)));
    }

    /**
     * Returns the id used to index models on Elastic Search
     * @return string
     */
    public function getIndexId()
    {
        return $this->{$this->primaryKey};
    }

    /**
     * Returns the different parameters to be indexed
     * @return mixed
     */
    public function getSearchableIndex()
    {
        return $this->toArray();
    }
}
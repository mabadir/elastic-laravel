<?php
namespace MAbadir\ElasticLaravel;

use Illuminate\Support\Facades\Facade;
use MAbadir\ElasticLaravel\Exceptions\NotValidEloquentException;

class ElasticSearcher extends Facade
{
    /**
     * Search the Elastic Search Index using the given parameters
     *
     * @param $params
     *
     * @return array
     */
    public static function search($params, $object = null)
    {
        $query = self::buildQuery($params);

        if(isset($object))
        {
            $query = static::addType($object) + $query;
        }

        return static::performSearch($query);
    }

    /**
     * Runs an advanced search against Elastic Search
     * @param $params
     *
     * @return array
     */
    public static function advanced($params, $object = null)
    {
        $query = [
            'body' => [
                'query' => $params
            ]
        ];
        if(isset($object))
        {
            $query = static::addType($object) + $query;
        }
        return static::performSearch($query);

    }

    /**
     * Calls the Search function on the ElasticSearch Client
     * @param $params
     *
     * @return array
     */
    protected static function performSearch($params)
    {
        return (new ElasticClient)->search($params);
    }

    /**
     * Checks whether the passed is an instance
     * of Eloquent model or class name
     *
     * @param $object
     *
     * @return array
     */
    protected static function addType($object)
    {
        if(is_object($object)){
            $type = static::checkValidEloquent($object);
        }
        else{
            $type = (new $object)->getTable();
        }
        return ["type"=>$type];
    }

    /**
     * Check whether the query is a simple text or an array
     *
     * @param $params
     *
     * @return array
     */
    protected static function buildQuery($params)
    {
        if (is_array($params)) {
            $query = self::handleArray($params);
        } else {
            $query = self::handleTerm($params);
        }
        return $query;
    }

    /**
     * Handles search if parameter is an array
     * @param $params
     *
     * @return array
     */
    protected static function handleArray($params)
    {
        return [
            'body' => [
                'query' => [
                    'match' => $params
                ]
            ]
        ];
    }

    /**
     * Handles search if parameter is a simple array
     * @param $params
     *
     * @return array
     */
    protected static function handleTerm($params)
    {
        return [
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => $params
                    ]
                ]
            ]
        ];
    }

    /**
     * @param $object
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function checkValidEloquent($object)
    {
        if (is_subclass_of($object, '\Illuminate\Database\Eloquent\Model'))
            $type = $object->getTable();
        else
            throw new NotValidEloquentException('Not a valid object, class should be extending Eloquent Model class.');
        return $type;
    }
}
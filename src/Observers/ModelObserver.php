<?php
/**
 * Created by PhpStorm.
 * User: mina
 * Date: 3/20/17
 * Time: 4:04 PM
 */

namespace MAbadir\ElasticLaravel\Observers;


use MAbadir\ElasticLaravel\Jobs\IndexModel;

class ModelObserver
{
    /**
     * Runs when a model is created
     * @param $model
     */
    public function created($model)
    {
        $params = [
            'type' => $model->getIndexType(),
            'id' => $model->getIndexId(),
            'body' => $model->getSearchableIndex(),
        ];
        dispatch(new IndexModel($model, $params,'index'));
    }

    /**
     * Runs when a model is updated
     * @param $model
     */
    public function updated($model)
    {
        $params = [
            'type' => $model->getIndexType(),
            'id' => $model->getIndexId(),
            'body' => [
                'doc' => $model->getSearchableIndex()
            ],
        ];
        dispatch(new IndexModel($model, $params,'update'));
    }

    /**
     * Runs when a model is updated
     * @param $model
     */
    public function restored($model)
    {
        $params = [
            'type' => $model->getIndexType(),
            'id' => $model->getIndexId(),
            'body' => $model->getSearchableIndex(),
        ];
        dispatch(new IndexModel($model, $params,'create'));
    }

    /**
     * Runs when a model is deleted
     * @param $model
     */
    public function deleting($model)
    {
        $params = [
            'type' => $model->getIndexType(),
            'id' => $model->getIndexId(),
        ];
        dispatch(new IndexModel($model, $params,'delete'));
    }
}
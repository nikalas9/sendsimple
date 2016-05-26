<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class GridSortAction extends BaseAction
{
    public function run()
    {
        if ( Yii::$app->request->post('sorter') )
        {
            $sortArray = Yii::$app->request->post('sorter',[]);

            $modelClass = $this->modelClass;

            $models = $modelClass::findAll(array_keys($sortArray));

            foreach ($models as $model)
            {
                $model->sorter = $sortArray[$model->id];
                $model->save(false);
            }
        }
    }
}
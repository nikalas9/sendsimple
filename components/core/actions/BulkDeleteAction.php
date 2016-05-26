<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class BulkDeleteAction extends BaseAction
{
    public function run()
    {
        if ( Yii::$app->request->post('selection') )
        {
            $modelClass = $this->modelClass;

            foreach (Yii::$app->request->post('selection', []) as $id)
            {
                $model = $modelClass::findOne($id);

                if ( $model )
                    $model->delete();
            }
        }
    }
}
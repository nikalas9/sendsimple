<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class BulkActivateAction extends BaseAction
{
    public function run()
    {
        if ( Yii::$app->request->post('selection') )
        {
            $modelClass = $this->modelClass;

            $modelClass::updateAll(
                ['status'=>1],
                ['id'=>Yii::$app->request->post('selection', [])]
            );
        }
    }
}
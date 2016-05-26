<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class GridEditableAction extends BaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isAjax) {

            $pk=\Yii::$app->request->post('pk');
            $name=\Yii::$app->request->post('name');
            $value=\Yii::$app->request->post('value');

            $model = $this->findModel($pk);
            \core\xeditable\XEditable::saveAction([
                'name' => $name,
                'value' => $value,
                'model' => $model,
            ]);
        }
    }
}
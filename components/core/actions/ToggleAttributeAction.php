<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class ToggleAttributeAction extends BaseAction
{
    public function run($attribute, $id)
    {
        $model = $this->findModel($id);
        $model->{$attribute} = ($model->{$attribute} == 1) ? 0 : 1;
        $model->save(false);
    }
}
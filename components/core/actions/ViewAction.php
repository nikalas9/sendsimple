<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class ViewAction extends BaseAction
{
    public function run($id)
    {
        $model = $this->findModel($id);

        Yii::$app->controller->beforeBreadcrumbs($model);

        return $this->renderIsAjax('view', [
            'model' => $model,
        ]);
    }
}
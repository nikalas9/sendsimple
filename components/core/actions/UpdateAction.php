<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class UpdateAction extends BaseAction
{
    public $scenarioOnUpdate;

    public function run($id)
    {
        $model = $this->findModel($id);

        if ( $this->scenarioOnUpdate )
        {
            $model->scenario = $this->scenarioOnUpdate;
        }

        if ( $model->load(Yii::$app->request->post()) && $model->save())
        {
            $redirect = $this->getRedirectPage('update', $model);

            return $redirect === false ? '' : $this->redirect($redirect);
        }

        Yii::$app->controller->beforeBreadcrumbs($model);

        return $this->renderIsAjax('update', compact('model'));
    }
}
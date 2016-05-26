<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class CreateAction extends BaseAction
{
    public $scenarioOnCreate;

    public function run()
    {
        $model = new $this->modelClass;

        if($this->scenarioOnCreate) {
            $model->scenario = $this->scenarioOnCreate;
        }

        if(Yii::$app->request->isPost and $model->load(Yii::$app->request->post())) {
            if($model->save()){
                $redirect = $this->getRedirectPage('create', $model);
                return $redirect === false ? '' : $this->redirect($redirect);
            }
        }
        else{
            $model->load(Yii::$app->request->get());
        }

        Yii::$app->controller->beforeBreadcrumbs($model);

        return $this->renderIsAjax('create', compact('model'));
    }
}
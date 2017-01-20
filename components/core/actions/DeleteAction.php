<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;
use yii\base\UserException;

class DeleteAction extends BaseAction
{
    public function run($id)
    {
        $model = $this->findModel($id);
        try {
            $model->delete();
        }
        catch (UserException $e) {
            Yii::$app->session->setFlash('error',$e->getMessage());
        }

        if(Yii::$app->request->isAjax){
            return $this->redirect(Yii::$app->request->referrer);
        }

        $redirect = $this->getRedirectPage('delete', $model);
        return $redirect === false ? '' : $this->redirect($redirect);
    }
}
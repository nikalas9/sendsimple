<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class DeleteAction extends BaseAction
{
    public function run($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $redirect = $this->getRedirectPage('delete', $model);

        return $redirect === false ? '' : $this->redirect($redirect);
    }
}
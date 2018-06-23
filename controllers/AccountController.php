<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class AccountController extends AdminController
{
    public $modelClass = 'app\models\Account';

    public $modelSearchClass = 'app\models\AccountSearch';

    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->update(false,['status']);

        return $this->redirect(['index']);
    }
}

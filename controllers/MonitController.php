<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class MonitController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}

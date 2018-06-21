<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class LoggerController extends AdminController
{
    public $modelClass = 'app\models\base\LogAlert';

    public $modelSearchClass = 'app\models\LogAlertSearch';

    public function actionClear() {

        Yii::$app->db->createCommand()->truncateTable('log_alert')->execute();
        $this->redirect(['/logger/index']);
    }
}

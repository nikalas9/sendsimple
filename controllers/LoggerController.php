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
}

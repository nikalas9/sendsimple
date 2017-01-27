<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class ClientsParamController extends AdminController
{
    public $modelClass = 'app\models\ClientsParam';

    public $modelSearchClass = 'app\models\ClientsParamSearch';
}

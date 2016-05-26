<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class BaseController extends AdminController
{
    public $modelClass = 'app\models\Base';

    public $modelSearchClass = 'app\models\BaseSearch';
}

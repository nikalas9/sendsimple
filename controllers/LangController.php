<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class LangController extends AdminController
{
    public $modelClass = 'app\models\Lang';

    public $modelSearchClass = 'app\models\LangSearch';
}

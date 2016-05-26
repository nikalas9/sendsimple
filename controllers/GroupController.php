<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class GroupController extends AdminController
{
    public $modelClass = 'app\models\Group';

    public $modelSearchClass = 'app\models\GroupSearch';
}

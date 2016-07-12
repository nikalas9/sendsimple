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
}

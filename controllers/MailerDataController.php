<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class MailerDataController extends AdminController
{
    public $modelClass = 'app\models\MailerData';

    public $modelSearchClass = 'app\models\MailerDataSearch';
}

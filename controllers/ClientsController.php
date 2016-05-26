<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class ClientsController extends AdminController
{
    public $modelClass = 'app\models\Clients';

    public $modelSearchClass = 'app\models\ClientsSearch';
}

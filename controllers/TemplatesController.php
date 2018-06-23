<?php
namespace app\controllers;

use app\models\Mailer;
use core\components\AdminController;
use core\helpers\Url;
use Yii;

/**
 * Site controller
 */
class TemplatesController extends AdminController
{
    public $modelClass = 'app\models\Templates';

    public $modelSearchClass = 'app\models\TemplatesSearch';

    public function actions()
    {
        return array_merge(parent::actions(), [
            'add-mail' => [
                'class' => 'app\components\actions\CopyMailAction',
                'modelTo' => 'app\models\Mailer'
            ],
        ]);
    }
}

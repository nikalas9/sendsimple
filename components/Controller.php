<?php

namespace app\components;

use Yii;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller
{

    public function init()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(["/user/login"]);
        }

        // check for admin permission (`tbl_role.can_admin`)
        // note: check for Yii::$app->user first because it doesn't exist in console commands (throws exception)
        /*if (!empty(Yii::$app->user) && !Yii::$app->user->can("admin")) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }*/

        /*if(Yii::$app->user->id){
            date_default_timezone_set(Yii::$app->user->identity->timezone);
        }*/
        parent::init();
    }

    protected function renderIsAjax($view, $params = [])
    {
        if ( Yii::$app->request->isAjax )
        {
            return $this->renderAjax($view, $params);
        }
        else
        {
            return $this->render($view, $params);
        }
    }
}
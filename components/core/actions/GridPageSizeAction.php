<?php

namespace core\actions;

use core\components\BaseAction;
use yii\web\Cookie;
use Yii;

class GridPageSizeAction extends BaseAction
{
    public function run()
    {
        if ( Yii::$app->request->post('grid-page-size') )
        {
            $cookie = new Cookie([
                'name' => '_grid_page_size',
                'value' => Yii::$app->request->post('grid-page-size'),
                'expire' => time() + 86400 * 365, // 1 year
            ]);

            Yii::$app->response->cookies->add($cookie);
        }
    }
}
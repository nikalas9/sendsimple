<?php

namespace app\models;

use Yii;

class LogAlert extends \app\models\base\LogAlert
{

    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Logger',
            'action'=>'Logger',
            'model'=>'Logger',
        ];
        return $arr[$key];
    }

    public function optionIndex()
    {
        $option = [
            'items' => [
                [
                    'class' => \core\components\gridColumns\SerialColumn::className(),
                ],

                'log_time',
                'message',
            ]
        ];

        return $option;
    }

}

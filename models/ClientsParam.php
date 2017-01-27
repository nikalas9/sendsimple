<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\behaviors\MaxOrderBehavior;

class ClientsParam extends \app\models\base\ClientsParam
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            MaxOrderBehavior::className(),
        ];
    }

    public static function find()
    {
        return new BaseQuery(get_called_class());
    }

    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Custom Fields',
            'action'=>'Fields',
            'model'=>'Field',
        ];
        return $arr[$key];
    }

    public function optionIndex()
    {
        $option = [
            'items' => [
                [
                    'class' => \core\components\gridColumns\SerialColumn::className(),
                    'attribute'=>'id',
                ],
                [
                    'class' => \core\components\gridColumns\SortColumn::className(),
                ],
                [
                    'class' => \core\components\gridColumns\StatusColumn::className(),
                    'attribute'=>'status',
                    'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'status', 'id'=>'_id_']),
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
                ],
                'alias',
                [
                    'class' => \core\components\gridColumns\CheckColumn::className(),
                    'attribute'=>'show',
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'options'=>['style'=>'width:10px']
                ],
                [
                    'class' => \core\components\ActionColumn::className(),
                ],
            ]
        ];

        return $option;
    }


    public function optionUpdate()
    {
        $option = [
            'items' => [
                'name' => 'Text',
                'alias' => 'Text',
                'type_id' => [
                    'type' => 'Select',
                    'data' => [
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                    ]
                ],
                'show' => 'Checkbox',
            ]
        ];

        return $option;
    }


    public function optionView()
    {
        $option = [
            'items' => [
                'id',
                'status',
                'name',
                'show',
            ]
        ];
        return $option;
    }
}

<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\behaviors\MaxOrderBehavior;

class Lang extends \app\models\base\Lang
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            MaxOrderBehavior::className(),
        ];
    }

    public static function getDropDownList()
    {
        return ArrayHelper::map(Lang::find()->active()->all(),'id','name');
    }

    public static function getMainLangId()
    {
        if($lang_main = Lang::find()
            ->where('main = 1')
            ->one()){
            return $lang_main->id;
        }
    }

    public static function find()
    {
        return new BaseQuery(get_called_class());
    }

    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Lang',
            'action'=>'Lang',
            'model'=>'Lang',
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
                [
                    'class' => \core\components\gridColumns\CheckColumn::className(),
                    'attribute'=>'main',
                    'filter'=>false,
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
                'main' => 'Checkbox',
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
                'main',
            ]
        ];
        return $option;
    }
}

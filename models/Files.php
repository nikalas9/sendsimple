<?php

namespace app\models;

use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Files extends \app\models\base\Files
{

    public function rules()
    {
        return [
            [['status', 'date_upload', 'iBook', 'iHeader', 'base_id', 'state'], 'integer'],
            //[['date_create', 'user_create', 'date_update', 'user_update', 'name', 'date_upload', 'iBook', 'iHeader', 'base_id', 'column'], 'required'],
            //[['column'], 'string'],
            [['name'], 'string', 'max' => 255],

            ['file', 'required', 'on'=>'create'],
            ['file', 'file', 'extensions'=>['xls','xlsx']],

            ['base_id', 'required', 'on'=>'update'],
            ['column', 'validateColumn', 'on'=>'update'],
        ];
    }

    public function validateColumn($attribute, $params)
    {
        if(is_array($this->$attribute)){
            if(in_array('email',$this->$attribute)){
                return true;
            }
            else{
                $this->addError($attribute, 'The E-mail must be selected');
            }
        }
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Import',
            'action'=>'Import',
            'model'=>'Import',
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
                    'class' => \core\components\gridColumns\StatusColumn::className(),
                    'attribute'=>'status',
                    'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'status', 'id'=>'_id_']),
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
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


    /*public function optionUpdate()
    {
        $option = [
            'items' => [
                'name' => 'Text',
            ]
        ];

        return $option;
    }*/


    public function optionView()
    {
        $option = [
            'items' => [
                'id',
                'status',
                'name',
                'created_at',
                'created_by',
            ]
        ];

        return $option;
    }
}

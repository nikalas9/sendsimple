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
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'date_upload', 'iBook', 'iHeader', 'base_id', 'state'], 'integer'],
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
                    'attribute'=>'status',
                    'filter'=>[0=>'Draft','1'=>'Completed'],
                    'value'=>function($model){
                        if($model->status == 0){
                            return '<span class="label label-warning" style="font-size:85%;"> Draft </span>';
                        }
                        if($model->status == 1){
                            return '<span class="label label-success" style="font-size:85%;"> Completed </span>';
                        }
                    },
                    'format'=>'html',
                    'headerOptions'=>['style'=>'width:100px']
                ],

                'name',
                [
                    'attribute'=>'base.name',
                ],

                [
                    'label'=>'Total',
                    'value'=>function($model){
                        if($model->result){
                            $result = json_decode($model->result,1);
                            return $result['total'];
                        }
                    }
                ],
                [
                    'label'=>'Created',
                    'value'=>function($model){
                        if($model->result){
                            $result = json_decode($model->result,1);
                            return $result['created'];
                        }
                    }
                ],
                [
                    'label'=>'Updated',
                    'value'=>function($model){
                        if($model->result){
                            $result = json_decode($model->result,1);
                            return $result['updated'];
                        }
                    }
                ],
                [
                    'label'=>'Dub',
                    'value'=>function($model){
                        if($model->result){
                            $result = json_decode($model->result,1);
                            return $result['dub'];
                        }
                    }
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

    public function optionView()
    {
        $option = [
            'items' => [
                'id',
                'status',
                'name',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'label'=>'Created By',
                    'attribute'=>'createdBy.username',
                ],
                [
                    'label'=>'Updated By',
                    'attribute'=>'updatedBy.username',
                ]
            ]
        ];

        return $option;
    }
}

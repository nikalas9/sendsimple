<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\base\UserException;

class Group extends \app\models\base\Group
{

    public function rules()
    {
        return [
            [['sort', 'status', 'account_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name', 'site', 'domain'], 'string', 'max' => 255],
            [['color_class'], 'string', 'max' => 50],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    public function beforeDelete()
    {
        $existBase = Base::find()
            ->where([
                'group_id'=>$this->id
            ])
            ->exists();
        if($existBase){
            throw new UserException('Record can not be deleted, there are active client base');
        }

        return parent::beforeDelete();
    }



    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Group',
            'action'=>'Group',
            'model'=>'Group',
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
                    'class' => \core\components\gridColumns\DateRangeColumn::className(),
                    'attribute'=>'created_at',
                    'format'=>'datetime',
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
                ],
                'site',
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
                'site' => 'Text',
                'color_class' => 'Color',
                'account_id' => [
                    'type'=>'Select',
                    'data'=> ArrayHelper::map(Account::find()->all(),'id','from_email'),
                    'options' => [
                        'prompt'=>'',
                    ]
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
                'site',
                'color_class',
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

<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Base extends \app\models\base\Base
{

    public function rules()
    {
        return [
            [['sort', 'status', 'lang_id'], 'integer'],
            [['name', 'group_id'], 'required'],
            [['group_id'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsBases()
    {
        return $this->hasMany(ClientsBase::className(), ['base_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
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
            'list'=>'Base',
            'action'=>'Base',
            'model'=>'Base',
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
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
                ],
                [
                    'class' => \core\components\gridColumns\Select2Column::className(),
                    'attribute'=>'group_id',
                    'filter'=> ArrayHelper::map(Group::find()->all(),'id','name'),
                    'value'=> function($model){
                        return Html::a($model->group->name,
                            Url::toRoute(['base/index','BaseSearch[group_id]'=>$model->group->id]),
                            ['class'=>'label '.$model->group->color_class]
                        );
                    },
                    'format'=>'raw',
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
                'group_id' => [
                    'type'=>'Select',
                    'data'=> ArrayHelper::map(Group::find()->all(),'id','name')
                ],
                'name' => 'Text',
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
                'group.name',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by'
            ]
        ];

        return $option;
    }
}

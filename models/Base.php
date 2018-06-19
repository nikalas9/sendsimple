<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\behaviors\MaxOrderBehavior;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

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

    public function delete()
    {
        $this->del = 1;
        $this->update(false, ['del']);
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
                    'value'=> function($model){
                        return date("d/m/Y H:i",$model->created_at);
                    },
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
                ],
                [
                    'class' => \core\components\gridColumns\Select2Column::className(),
                    'attribute'=>'group_id',
                    'filter'=> ArrayHelper::map(Group::find()->all(),'id','name'),
                    'value'=> function($model){
                        if($model->group){
                            return Html::a($model->group->name,
                                Url::toRoute(['base/index','BaseSearch[group_id]'=>$model->group->id]),
                                ['class'=>'label '.$model->group->color_class]
                            );
                        }
                    },
                    'format'=>'raw',
                ],
                [
                    'attribute'=>'lang_id',
                    'filter'=> ArrayHelper::map(Lang::find()->all(),'id','name'),
                    'value'=> function($model){
                        return $model->lang ? $model->lang->name : '';
                    },
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


    public function optionUpdate($model)
    {
        if($model->isNewRecord){
            $model->lang_id = Lang::getMainLangId();
        }

        $option = [
            'items' => [
                'group_id' => [
                    'type' =>'Select',
                    'data' => Group::getDropDownList(),
                    'options' => [
                        'prompt' => ''
                    ]
                ],
                'name' => 'Text',
                'lang_id' => [
                    'type'=>'Select',
                    'data'=> Lang::getDropDownList(),
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
                'group.name',
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

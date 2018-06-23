<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Templates extends \app\models\base\Templates
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
            [['body', 'temp_id', 'files', 'mode_id'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
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
            'list'=>'Templates',
            'action'=>'Templates',
            'model'=>'Templates',
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
                    'class' => \core\components\gridColumns\DateRangeColumn::className(),
                    'attribute'=>'created_at',
                    'format'=>'datetime',
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
                ],
                [
                    'label' => 'Preview',
                    'format' => 'html',
                    'value' => function ($data) {
                        $preview = '/public/template/' . $data->temp_id . '/preview.jpg';
                        if (file_exists('./' . $preview)) {
                            return Html::a(Html::img($preview, ['width'=>100]),$preview, ['class'=>'preview']);
                        }
                        return '';
                    },
                    'headerOptions' => [
                        'style'=>'width:100px;'
                    ],
                ],
                [
                    'class' => \core\components\gridColumns\Select2Column::className(),
                    'attribute'=>'group_id',
                    'filter'=> ArrayHelper::map(Group::find()->all(),'id','name'),
                    'value'=> function($model){
                        if($model->group){
                            return Html::a($model->group->name,
                                Url::toRoute(['mailer/index','MailerSearch[group_id]'=>$model->group->id]),
                                [
                                    'class'=> $model->group->color_class ? 'label '.$model->group->color_class : '',
                                    'data-pjax' => 0
                                ]
                            );
                        }
                    },
                    'format'=>'raw',
                ],
                [
                    'label' => 'Create Mail',
                    'value' => function ($data) {
                        return Html::a('Create', ['add-mail', 'id' => $data->id], [
                            'data-pjax' => 0,
                            'class' => 'btn btn-warning btn-xs'
                        ]);
                    },
                    'format' => 'raw',
                    'headerOptions' => [
                        'style'=>'width:100px;'
                    ],
                    'contentOptions' => [
                        'style'=>'text-align:center'
                    ],
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
                    'type' =>'Select',
                    'data'=>Group::getDropDownList(),
                    'options' => [
                        'prompt' => ''
                    ]
                ],
                'name' => 'Text',
                'body' => 'Builder',
            ]
        ];

        return $option;
    }


    public function optionView($model)
    {
        $option = [
            'items' => [
                'id',
                'status',
                'name',
                [
                    'attribute' => 'group_id',
                    'value' => $model->group->name,
                ],
                [
                    'attribute' => 'body',
                    'value' => '<iframe width="100%" frameborder="0" vspace="0" hspace="0" scrolling="no" src="'
                        . Url::toRoute(['letter/view','key'=>$model->temp_id])
                        . '" id="templateViewer"></iframe>',
                    'format' => 'raw'
                ],
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
            ],
            'widgetOption' => [
                'class'=>'table table-striped table-bordered detail-view',
            ]
        ];

        return $option;
    }
}

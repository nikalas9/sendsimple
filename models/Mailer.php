<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Mailer extends \app\models\base\Mailer
{
    const STATE_DRAFT = 0;
    const STATE_QUEUED = 1;
    const STATE_SENDING = 2;
    const STATE_FINISH = 3;
    const STATE_CANCEL = 4;
    const STATE_PAUSE = 5;
    const STATE_ERROR = -1;

    public $value;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'account_id'], 'integer'],
            [['body', 'temp_id', 'files', 'mode_id'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['base_ids'], 'safe'],
        ];
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
    public function getCountStack()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountSend()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])->andWhere('send is not null')->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountDeliver()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])->andWhere('error is null')->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountOpen()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])->andWhere('open is not null')->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountSpam()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])->andWhere('spam is not null')->count();
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
            'list'=>'Mailer',
            'action'=>'Mailer',
            'model'=>'Mailer',
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
                    'value' => function($model){
                        $status = array(
                            0 => 'Draft',
                            1 => 'Queued',
                            2 => 'Distribution',
                            3 => 'Finish',
                            4 => 'Cancel',
                            5 => 'Pause',
                            -1 => 'Error',
                        );
                        $label = 'default';
                        switch($model->status) {
                            case '0':  $label = 'default'; break;
                            case '1':  $label = 'warning'; break;
                            case '2':  $label = 'warning'; break;
                            case '3':  $label = 'success'; break;
                            case '4':  $label = 'default'; break;
                            case '5':  $label = 'info'; break;
                            case '-1':  $label = 'error'; break;
                        }
                        return '<span style="font-size:85%;" class="label label-'.$label.'">'.$status[$model->status].'</span>';
                    },
                    'filter' => [
                        0 => 'Draft',
                        1 => 'Queued',
                        2 => 'Distribution',
                        3 => 'Finish',
                        4 => 'Cancel',
                        5 => 'Pause',
                        -1 => 'Error',
                    ],
                    'format' => 'html',
                    'contentOptions' => [
                        'style'=>'text-align:center; width:80px; white-space:nowrap;'
                    ],
                ],
                [
                    'class' => \core\components\gridColumns\DateRangeColumn::className(),
                    'attribute'=>'created_at',
                    'format'=>'datetime',
                ],
                [
                    'attribute' => 'name',
                    'value' => function ($data) {
                        if ($data->status == Mailer::STATE_DRAFT) {
                            return Html::a($data->name, ['update', 'id' => $data->id], ['data-pjax'=>0], true);
                        } elseif (in_array($data->status, [Mailer::STATE_QUEUED, Mailer::STATE_SENDING])) {
                            return Html::a($data->name, ['state', 'id' => $data->id], ['data-pjax'=>0], true);
                        } else {
                            return Html::a($data->name, ['view', 'id' => $data->id], ['data-pjax'=>0], true);
                        }
                    },
                    'format' => 'raw',
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
                /*[
                    'label' => 'Stack',
                    'value'=> function($model){
                        return $model->countStack ? $model->countStack->value : '';
                    }
                ],
                [
                    'label' => 'Send',
                    'value'=> function($model){
                        return $model->countSend ? $model->countSend->value : '';
                    }
                ],
                [
                    'label' => 'Deliver',
                    'value'=> function($model){
                        return $model->countDeliver ? $model->countDeliver->value : '';
                    }
                ],
                [
                    'label' => 'Open',
                    'value'=> function($model){
                        return $model->countOpen ? $model->countOpen->value : '';
                    }
                ],
                [
                    'header' => 'Detail',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if($model->countStack){
                            return Html::a('<i class="glyphicon glyphicon-folder-open"></i>',
                                ['mailer-data/index', 'MailerDataSearch[mailer_id]' => $model->id],
                                ['class'=>'btn btn-info btn-xs','data-pjax'=>0]);
                        } else {
                            return Html::a('<i class="glyphicon glyphicon-folder-open"></i>',
                                ['mailer-data/index', 'MailerDataSearch[mailer_id]' => $model->id],
                                ['class'=>'btn btn-info btn-xs','data-pjax'=>0]);
                        }
                    },
                    'filter'=>false,
                    'contentOptions'=>['style'=>'width:80px; text-align:center;'],
                ],*/
                /*[
                    'class' => 'yii\grid\CheckboxColumn',
                    'options'=>['style'=>'width:10px']
                ],
                [
                    'class' => \core\components\ActionColumn::className(),
                ],*/
            ]
        ];

        return $option;
    }


    public function optionUpdate()
    {
        $base = Base::find()->with(['group'])->all();
        $baseData = ArrayHelper::map($base,'id','name','group.name');

        $option = [
            'items' => [
                'group_id' => [
                    'type' =>'Select',
                    'data'=>Group::getDropDownList(),
                    'options' => [
                        'prompt' => ''
                    ]
                ],
                'base_ids'=>[
                    'type'=>'Select2',
                    'data'=>$baseData,
                    'options'=>[
                        'multiple'=>true
                    ]
                ],
                'account_id' => [
                    'type'=>'Select',
                    'data'=>Account::getDropDownList(),
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
            ]
        ];

        return $option;
    }
}

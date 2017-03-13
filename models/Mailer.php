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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'account_id'], 'integer'],
            [['base_ids', 'account_id', 'name'], 'required'],
            [['body', 'temp_id', 'files'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function load($data, $formName = null)
    {
        if(Yii::$app->request->isPost){
            $data['Mailer']['base_ids'] = implode(',',$data['Mailer']['base_ids']);
        }
        return parent::load($data, $formName);
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
        ])
            ->select('mailer_id, count(*) as value');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountSend()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])
            ->andWhere('send is not null')
            ->select('mailer_id, count(*) as value');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountDeliver()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])
            ->andWhere('deliver is not null')
            ->select('mailer_id, count(*) as value');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountOpen()
    {
        return $this->hasOne(MailerData::className(), [
            'mailer_id' => 'id',
        ])
            ->andWhere('open is not null')
            ->select('id, count(*) as value');
    }


    /*public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }*/

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
                            10 => 'Error',
                            -1 => 'Delete',
                        );
                        $label = 'default';
                        switch($model->status) {
                            case '0':  $label = 'default'; break;
                            case '1':  $label = 'warning'; break;
                            case '2':  $label = 'warning'; break;
                            case '3':  $label = 'success'; break;
                            case '4':  $label = 'default'; break;
                            case '5':  $label = 'info'; break;
                            case '10':  $label = 'error'; break;
                        }
                        return '<span style="font-size:85%;" class="label label-'.$label.'">'.$status[$model->status].'</span>';
                    },
                    'format' => 'html',
                    'contentOptions' => [
                        'style'=>'text-align:center; width:80px; white-space:nowrap;'
                    ],
                ],
                [
                    'class' => \core\components\gridColumns\NameColumn::className(),
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


    public function optionView()
    {
        $option = [
            'items' => [
                'name',
            ]
        ];

        return $option;
    }
}

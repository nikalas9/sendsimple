<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Clients extends \app\models\base\Clients
{
    public $baseIds;

    const STATE_NEW = 0;
    const STATE_ACTIVE = 1;
    const STATE_ERROR = -1;
    const STATE_BOUNCE = -2;
    const STATE_UNSUBSCRIBE = -3;

    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'country_id', 'city_id'], 'integer'],
            [['email', 'baseIds'], 'required'],
            [['other'], 'string'],
            [['email'], 'unique'],
            [['email'], 'string', 'max' => 100],
            [['baseIds'], 'safe'],
        ];
    }

    public function load($data, $formName = null)
    {
        if(Yii::$app->request->isPost){
            $data['Clients']['other'] = json_encode($data['Clients']['other']);
        }
        return parent::load($data, $formName);
    }


    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($this->baseIds != null) {

            $thisClientBase = ClientsBase::find()
                ->andWhere([
                    'client_id'=>$this->id
                ])
                ->all();
            $thisClientBaseIds = ArrayHelper::map($thisClientBase,'base_id','base_id');
            foreach($this->baseIds as $baseId){
                if(!isset($thisClientBaseIds[$baseId])){
                    $clientBase = new ClientsBase();
                    $clientBase->status = 0;
                    $clientBase->base_id = $baseId;
                    $clientBase->client_id = $this->id;
                    $clientBase->save(false);
                }
                unset($thisClientBaseIds[$baseId]);
            }
            if($thisClientBaseIds){
                foreach($thisClientBaseIds as $baseId){
                    ClientsBase::deleteAll([
                        'client_id'=>$this->id,
                        'base_id'=>$baseId
                    ]);
                }
            }
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        ClientsBase::deleteAll(['client_id'=>$this->id]);
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
            'list'=>'Clients',
            'action'=>'Clients',
            'model'=>'Clients',
        ];
        return $arr[$key];
    }

    public function optionIndex($model)
    {
        $other = ClientsParam::find()->all();
        $otherColumnAttributes = [];
        foreach($other as $row){
            $otherColumnAttributes[] = [
                'label' => $row['name'],
                'filter' => Html::activeTextInput($model, 'other['.$row['alias'].']', [
                    'class' => 'form-control',
                    'id' => null
                ]),
                'value' => function($data) use ($row){
                    $other = json_decode($data->other,1);
                    return isset($other[$row['alias']]) ? $other[$row['alias']] : false;
                }
            ];
        }

        $option = [
            'items' => array_merge(
                [
                    [
                        'class' => \core\components\gridColumns\SerialColumn::className(),
                        'attribute'=>'id',
                    ],
                    [
                        'attribute'=>'status',
                        'value' => function($model){
                            $status = array(
                                0 => 'New',
                                1 => 'Active',
                                -1 => 'Error',
                                -2 => 'Bounce',
                                -3 => 'Unsubscribe',
                            );
                            $label = 'default';
                            switch($model->status) {
                                case '0':  $label = 'default'; break;
                                case '1':  $label = 'success'; break;
                                case '-1':  $label = 'error'; break;
                                case '-2':  $label = 'warning'; break;
                                case '-3':  $label = 'warning'; break;
                            }
                            return '<span style="font-size:85%;" class="label label-'.$label.'">'.$status[$model->status].'</span>';
                        },
                        'filter' => [
                            0 => 'New',
                            1 => 'Active',
                            -1 => 'Error',
                            -2 => 'Bounce',
                            -3 => 'Unsubscribe',
                        ],
                        'format' => 'html',
                        'contentOptions' => [
                            'style'=>'text-align:center; width:80px; white-space:nowrap;'
                        ],
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
                        'attribute'=>'email',
                    ]
                ],
                $otherColumnAttributes,
                [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'options'=>['style'=>'width:10px']
                    ],
                    [
                        'class' => \core\components\ActionColumn::className(),
                    ],
                ]
            )
        ];

        return $option;
    }


    public function optionUpdate()
    {
        $option = [
            'items' => [
                'baseIds'=>[
                    'type'=>'Select2',
                    'data'=>ArrayHelper::map(Base::find()->with(['group'])->active()->all(),'id','name','group.name'),
                    'options'=>[
                        'multiple'=>true
                    ]
                ],
                'email' => 'Text',
            ]
        ];

        $other = ClientsParam::find()->all();
        if($other){
            foreach($other as $item){
                $option['items']['other['.$item->alias.']'] = [
                    'type' => ucfirst($item->type_id),
                    'label' => $item->name
                ];
            }
        }

        $this->baseIds = ArrayHelper::getColumn(ClientsBase::find()
            ->andWhere([
                'client_id'=>$this->id
            ])
            ->all(),'base_id');
        $this->other = json_decode($this->other,1);

        return $option;
    }


    public function optionView()
    {
        $other = ClientsParam::find()->all();
        $otherAttributes = [];
        foreach($other as $row){
            $otherAttributes[] = [
                'label' => $row['name'],
                'attribute' => 'other.'.$row['alias']
            ];
        }

        $option = [
            'items' => array_merge(
                [
                    'id',
                    'status',
                    'email',
                ],
                $otherAttributes,
                [
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
            )
        ];

        $this->other = json_decode($this->other,1);
        return $option;
    }
}

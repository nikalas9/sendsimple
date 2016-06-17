<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Clients extends \app\models\base\Clients
{
    public $baseIds;

    public function rules()
    {
        return [
            [['status', 'date_create', 'user_create', 'date_update', 'user_update', 'country_id', 'city_id'], 'integer'],
            [['email','baseIds'], 'required'],
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

    public function optionIndex()
    {
        $other = ClientsParam::find()->all();
        $otherColumnAttributes = [];
        foreach($other as $row){
            $otherColumnAttributes[] = [
                'label'=>$row['name'],
                'attribute'=>'other.'.$row['alias'],
                'value'=>function($data) use ($row){
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
                    'data'=>ArrayHelper::map(Base::find()->with(['group'])->all(),'id','name','group.name'),
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
                    'type'=>'Text',
                    'label'=>$item->name
                ];
            }
        }

        $this->baseIds = ArrayHelper::getColumn(ClientsBase::find()->andWhere(['client_id'=>$this->id])->all(),'base_id');
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
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                ]
            )
        ];

        $this->other = json_decode($this->other,1);
        return $option;
    }
}

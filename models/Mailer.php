<?php

namespace app\models;

use yii\helpers\ArrayHelper;
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
            [['account_id'], 'integer'],
            [['base_ids', 'account_id', 'name'], 'required'],
            [['body', 'files'], 'string'],
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


    public function optionUpdate()
    {
        $base = Base::find()->with(['group'])->all();
        $baseData = ArrayHelper::map($base,'id','name','group.name');

        $account = Account::find()->all();
        $accountData = [];
        if($account){
            foreach($account as $row){
                $accountData[ $row['id'] ] = $row['from_email'].' ('.$row['from_name'].')';
            }
        }

        $option = [
            'items' => [
                'base_ids'=>[
                    'type'=>'Select2',
                    'data'=>$baseData,
                    'options'=>[
                        'multiple'=>true
                    ]
                ],
                'account_id' => [
                    'type'=>'Select',
                    'data'=>$accountData,
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

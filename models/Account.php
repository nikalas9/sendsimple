<?php

namespace app\models;

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\behaviors\MaxOrderBehavior;

class Account extends \app\models\base\Account
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['from_name', 'from_email'], 'required'],
            [['from_name', 'from_email', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'imap_host', 'imap_port', 'imap_username', 'imap_password', 'imap_encryption'], 'string', 'max' => 100],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            MaxOrderBehavior::className(),
        ];
    }

    public static function getDropDownList()
    {
        $account = Account::find()->active()->all();
        $accountData = [];
        if($account){
            foreach($account as $row){
                $accountData[ $row['id'] ] = $row['from_email'].' ('.$row['from_name'].')';
            }
        }
        return $accountData;
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
            'list'=>'Account',
            'action'=>'Account',
            'model'=>'Account',
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
                    'attribute'=>'from_email',
                ],
                'from_name',
                'smtp_host',
                [
                    'class' => \core\components\ActionColumn::className(),
                ]
            ]
        ];

        return $option;
    }


    public function optionUpdate()
    {
        $option = [
            'items' => [
                'from_email' => 'Text',
                'from_name' => 'Text',
                'smtp_host' => 'Text',
                'smtp_port' => 'Text',
                'smtp_username' => 'Text',
                'smtp_password' => 'Text',
                'smtp_encryption' => 'Text',
                'imap_host' => 'Text',
                'imap_port' => 'Text',
                'imap_username' => 'Text',
                'imap_password' => 'Text',
                'imap_encryption' => 'Text',
            ]
        ];

        return $option;
    }


    public function optionView($model)
    {


        $option = [
            'items' => [
                'id',
                [
                    'attribute' => 'status',
                    'value' => (
                        $model->status == -1
                            ? Html::a('Enable', ['enable', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-success',
                                'data' => [
                                    'confirm' => 'Are you sure you want to enable this account?',
                                    'method' => 'post',
                                ],
                            ])
                            :  $model->status
                    ),
                    'format' => 'raw',
                ],
                'from_email',
                'from_name',
                'smtp_host',
                'smtp_port',
                'smtp_username',
                'smtp_password',
                'smtp_encryption',
                'imap_host',
                'imap_port',
                'imap_username',
                'imap_password',
                'imap_encryption',
            ]
        ];

        return $option;
    }
}

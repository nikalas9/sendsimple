<?php

namespace app\models;

use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

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
            [['from_name', 'from_email', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password'], 'string', 'max' => 100],
        ];
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
                'from_email',
                'from_name',
            ]
        ];

        return $option;
    }
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "tbl_account".
 *
 * @property string $id
 * @property string $sort
 * @property integer $status
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $from_name
 * @property string $from_email
 * @property string $smtp_host
 * @property string $smtp_port
 * @property string $smtp_username
 * @property string $smtp_password
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'from_name', 'from_email', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password'], 'required'],
            [['from_name', 'from_email', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Sort',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'from_name' => 'From Name',
            'from_email' => 'From Email',
            'smtp_host' => 'Smtp Host',
            'smtp_port' => 'Smtp Port',
            'smtp_username' => 'Smtp Username',
            'smtp_password' => 'Smtp Password',
        ];
    }
}

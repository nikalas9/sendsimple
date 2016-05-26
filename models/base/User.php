<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property integer $status
 * @property integer $date_create
 * @property string $user_create
 * @property integer $date_update
 * @property string $user_update
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $image
 * @property string $timezone
 * @property string $apikey
 * @property string $role_id
 * @property string $group_ids
 * @property string $base_ids
 * @property string $templates
 * @property integer $points
 * @property string $session_id
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'date_create', 'user_create', 'date_update', 'user_update', 'role_id', 'points'], 'integer'],
            [['date_create', 'user_create', 'date_update', 'user_update', 'username', 'password', 'email', 'name', 'image', 'timezone', 'apikey', 'group_ids', 'base_ids', 'templates', 'points', 'session_id'], 'required'],
            [['group_ids', 'base_ids', 'templates'], 'string'],
            [['username', 'password', 'email', 'name', 'image', 'session_id'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 50],
            [['apikey'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'date_create' => 'Date Create',
            'user_create' => 'User Create',
            'date_update' => 'Date Update',
            'user_update' => 'User Update',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'name' => 'Name',
            'image' => 'Image',
            'timezone' => 'Timezone',
            'apikey' => 'Apikey',
            'role_id' => 'Role ID',
            'group_ids' => 'Group Ids',
            'base_ids' => 'Base Ids',
            'templates' => 'Templates',
            'points' => 'Points',
            'session_id' => 'Session ID',
        ];
    }
}

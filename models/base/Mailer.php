<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%mailer}}".
 *
 * @property string $id
 * @property integer $status
 * @property integer $date_create
 * @property string $user_create
 * @property integer $date_update
 * @property string $user_update
 * @property string $name
 * @property integer $lang_id
 * @property integer $template_id
 * @property integer $news_id
 * @property integer $group_id
 * @property string $base_id
 * @property string $from_name
 * @property string $from_email
 * @property integer $date_start
 * @property integer $temp_id
 * @property string $body
 * @property string $files
 * @property integer $max
 */
class Mailer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mailer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'date_create', 'user_create', 'date_update', 'user_update', 'lang_id', 'template_id', 'news_id', 'group_id', 'date_start', 'temp_id', 'max'], 'integer'],
            [['name', 'lang_id', 'template_id', 'news_id', 'group_id', 'base_id', 'from_name', 'from_email', 'date_start', 'temp_id', 'body', 'files'], 'required'],
            [['base_id', 'body', 'files'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['from_name', 'from_email'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'lang_id' => 'Lang ID',
            'template_id' => 'Template ID',
            'news_id' => 'News ID',
            'group_id' => 'Group ID',
            'base_id' => 'Base ID',
            'from_name' => 'From Name',
            'from_email' => 'From Email',
            'date_start' => 'Date Start',
            'temp_id' => 'Temp ID',
            'body' => 'Body',
            'files' => 'Files',
            'max' => 'Max',
        ];
    }
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%mailer_data}}".
 *
 * @property string $id
 * @property string $date_update
 * @property integer $status
 * @property integer $client_id
 * @property integer $base_id
 * @property integer $mailer_id
 * @property integer $triger_id
 * @property integer $welcome_id
 * @property integer $news_id
 * @property integer $lang_id
 * @property integer $send
 * @property integer $deliver
 * @property string $open
 * @property integer $spam
 * @property string $link
 * @property string $error
 * @property string $hash
 * @property string $info
 * @property string $server
 */
class MailerData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mailer_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_update'], 'safe'],
            [['status', 'client_id', 'base_id', 'mailer_id', 'triger_id', 'welcome_id', 'news_id', 'lang_id', 'send', 'deliver', 'spam'], 'integer'],
            [['client_id', 'base_id', 'mailer_id', 'triger_id', 'welcome_id', 'news_id', 'lang_id', 'error', 'hash', 'info', 'server'], 'required'],
            [['open', 'link', 'error', 'info', 'server'], 'string'],
            [['hash'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_update' => 'Date Update',
            'status' => 'Status',
            'client_id' => 'Client ID',
            'base_id' => 'Base ID',
            'mailer_id' => 'Mailer ID',
            'triger_id' => 'Triger ID',
            'welcome_id' => 'Welcome ID',
            'news_id' => 'News ID',
            'lang_id' => 'Lang ID',
            'send' => 'Send',
            'deliver' => 'Deliver',
            'open' => 'Open',
            'spam' => 'Spam',
            'link' => 'Link',
            'error' => 'Error',
            'hash' => 'Hash',
            'info' => 'Info',
            'server' => 'Server',
        ];
    }
}

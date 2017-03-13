<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "tbl_tmp_link".
 *
 * @property integer $id
 * @property integer $mailer_data_id
 * @property string $link
 * @property string $hash
 * @property integer $count
 * @property integer $created_at
 */
class TmpLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_tmp_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mailer_data_id', 'count', 'created_at'], 'integer'],
            [['link'], 'string'],
            [['hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mailer_data_id' => 'Mailer Data ID',
            'link' => 'Link',
            'hash' => 'Hash',
            'count' => 'Count',
            'created_at' => 'Created At',
        ];
    }
}

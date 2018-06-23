<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "tbl_templates".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $body
 * @property string $temp_id
 * @property integer $lang_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 * @property integer $del
 * @property string $files
 * @property string $mode_id
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'lang_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'del'], 'integer'],
            [['body', 'files'], 'string'],
            [['mode_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['temp_id', 'mode_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'body' => 'Body',
            'temp_id' => 'Temp ID',
            'lang_id' => 'Lang ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'del' => 'Del',
            'files' => 'Files',
            'mode_id' => 'Mode ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'updated_by']);
    }
}

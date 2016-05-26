<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property string $id
 * @property string $ord
 * @property integer $status
 * @property integer $date_create
 * @property string $user_create
 * @property integer $date_update
 * @property string $user_update
 * @property string $name
 * @property string $file
 * @property integer $date_upload
 * @property integer $iBook
 * @property integer $iHeader
 * @property integer $base_id
 * @property string $column
 * @property integer $state
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ord', 'status', 'date_create', 'user_create', 'date_update', 'user_update', 'date_upload', 'iBook', 'iHeader', 'base_id', 'state'], 'integer'],
            [['date_create', 'user_create', 'date_update', 'user_update', 'name', 'date_upload', 'iBook', 'iHeader', 'base_id', 'column'], 'required'],
            [['column'], 'string'],
            [['name', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ord' => 'Ord',
            'status' => 'Status',
            'date_create' => 'Date Create',
            'user_create' => 'User Create',
            'date_update' => 'Date Update',
            'user_update' => 'User Update',
            'name' => 'Name',
            'file' => 'File',
            'date_upload' => 'Date Upload',
            'iBook' => 'I Book',
            'iHeader' => 'I Header',
            'base_id' => 'Base ID',
            'column' => 'Column',
            'state' => 'State',
        ];
    }
}

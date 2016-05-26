<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property string $id
 * @property string $sort
 * @property integer $status
 * @property string $name
 * @property string $site
 * @property integer $account_id
 * @property string $domain
 * @property string $color_class
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'account_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'site', 'account_id', 'domain', 'color_class', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['name', 'site', 'domain'], 'string', 'max' => 255],
            [['color_class'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'site' => 'Site',
            'account_id' => 'Account ID',
            'domain' => 'Domain',
            'color_class' => 'Color Class',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}

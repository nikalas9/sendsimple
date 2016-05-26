<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%base}}".
 *
 * @property string $id
 * @property string $sort
 * @property integer $status
 * @property string $name
 * @property integer $lang_id
 * @property string $group_id
 *
 * @property ClientsBase[] $clientsBases
 */
class Base extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'lang_id'], 'integer'],
            [['name', 'lang_id', 'group_id'], 'required'],
            [['group_id'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'lang_id' => 'Lang ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsBases()
    {
        return $this->hasMany(ClientsBase::className(), ['base_id' => 'id']);
    }
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%lang}}".
 *
 * @property string $id
 * @property string $sort
 * @property integer $status
 * @property string $name
 * @property integer $main
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'main'], 'integer'],
            [['name'], 'required'],
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
            'main' => 'Main',
        ];
    }
}

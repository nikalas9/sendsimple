<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%clients_param}}".
 *
 * @property string $id
 * @property string $sort
 * @property integer $status
 * @property string $alias
 * @property string $name
 * @property string $type_id
 * @property integer $show
 */
class ClientsParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients_param}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'show'], 'integer'],
            [['alias', 'name', 'type_id'], 'required'],
            [['alias', 'name'], 'string', 'max' => 255],
            [['type_id'], 'string', 'max' => 10],
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
            'alias' => 'Alias',
            'name' => 'Name',
            'type_id' => 'Type ID',
            'show' => 'Show',
        ];
    }
}

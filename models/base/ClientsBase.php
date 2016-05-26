<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%clients_base}}".
 *
 * @property string $id
 * @property integer $status
 * @property string $client_id
 * @property string $base_id
 *
 * @property Clients $client
 * @property Base $base
 */
class ClientsBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients_base}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'client_id', 'base_id'], 'integer'],
            [['client_id', 'base_id'], 'required'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['base_id'], 'exist', 'skipOnError' => true, 'targetClass' => Base::className(), 'targetAttribute' => ['base_id' => 'id']],
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
            'client_id' => 'Client ID',
            'base_id' => 'Base ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBase()
    {
        return $this->hasOne(Base::className(), ['id' => 'base_id']);
    }
}

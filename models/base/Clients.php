<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%clients}}".
 *
 * @property string $id
 * @property integer $status
 * @property integer $date_create
 * @property integer $user_create
 * @property integer $date_update
 * @property integer $user_update
 * @property string $email
 * @property integer $country_id
 * @property integer $city_id
 * @property string $other
 *
 * @property ClientsBase[] $clientsBases
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'date_create', 'user_create', 'date_update', 'user_update', 'country_id', 'city_id'], 'integer'],
            [['email', 'country_id', 'city_id', 'other'], 'required'],
            [['other'], 'string'],
            [['email'], 'string', 'max' => 100],
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
            'email' => 'Email',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'other' => 'Other',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsBases()
    {
        return $this->hasMany(ClientsBase::className(), ['client_id' => 'id']);
    }
}

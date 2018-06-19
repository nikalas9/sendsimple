<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MailSettingForm extends Model
{
    public $account_id;

    public $group_id;

    public $base_ids;


    public function rules()
    {
        return [
            [['group_id', 'account_id', 'base_ids'], 'required'],
            [['group_id', 'account_id'], 'integer'],
            [['base_ids'], 'safe'],
        ];
    }

    public function load($data, $formName = null)
    {
        if(Yii::$app->request->isPost){
            $data['MailSettingForm']['base_ids'] = implode(',',$data['MailSettingForm']['base_ids']);
        }
        return parent::load($data, $formName);
    }
}

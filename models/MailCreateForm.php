<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MailCreateForm extends Model
{
    public $name;
    public $temp_id;
    public $mode_id;
    public $body;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name','temp_id', 'mode_id'], 'string'],
            ['body', 'safe'],
        ];
    }
}

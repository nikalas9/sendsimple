<?php

namespace core\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class MaxOrderBehavior extends Behavior
{
    public $orderAttribute = 'sort';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    public function beforeInsert($event)
    {
        $this->owner->{$this->orderAttribute} = $this->owner->find()->count()+1;
    }
}

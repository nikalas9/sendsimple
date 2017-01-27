<?php

namespace app\models;

class BaseQuery extends \yii\db\ActiveQuery
{
    public function active($state = 1)
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this->andWhere([$tableName.'.status' => $state]);
    }
}
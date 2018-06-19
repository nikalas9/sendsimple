<?php

namespace app\models;

class BaseQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        parent::init();

        $modelClass = $this->modelClass;
        $model = new $modelClass;
        if ($model->hasAttribute('del')) {
            $tableName = $modelClass::tableName();
            return $this->andWhere([$tableName.'.del' => 0]);
        }
    }

    public function active($state = 1)
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this->andWhere([$tableName.'.status' => $state]);
    }
}
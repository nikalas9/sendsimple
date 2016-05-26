<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;
use yii\helpers\ArrayHelper;

class SelectAction extends BaseAction
{
    public function run($attribute,$query)
    {
        $modelClass = $this->modelClass;

        $list = $modelClass::find()
            ->select([$attribute])
            ->distinct()
            ->andFilterWhere(['~*',$attribute,$query])
            ->orderBy($attribute)
            ->limit(10)
            ->asArray()
            ->all();

        echo json_encode([
            'query'=>$query,
            'suggestions'=> ArrayHelper::getColumn($list,$attribute)
        ]);
    }
}
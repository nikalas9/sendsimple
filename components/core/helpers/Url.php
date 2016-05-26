<?php

namespace core\helpers;

use Yii;

class Url extends \yii\helpers\BaseUrl
{

    public static function toRoute($route, $scheme = false)
    {
        $className = Yii::$app->controller->modelSearchClass;
        if(isset($className::$parentKeys)){

            if($route[0] == 'index'){
                $sourceClassName = \yii\helpers\StringHelper::basename(Yii::$app->controller->modelSearchClass);
                $receiverClassName = \yii\helpers\StringHelper::basename(Yii::$app->controller->modelClass);
            }
            else{
                $sourceClassName = \yii\helpers\StringHelper::basename(Yii::$app->controller->modelClass);
                $receiverClassName = \yii\helpers\StringHelper::basename(Yii::$app->controller->modelSearchClass);
            }

            $filter = [];
            if(isset($className::$parentKeys)){
                foreach($className::$parentKeys as $key){
                    if(isset(Yii::$app->request->get($sourceClassName)[$key])){
                        $filter[$sourceClassName][$key] = Yii::$app->request->get($sourceClassName)[$key];
                    }
                    elseif(isset(Yii::$app->request->get($receiverClassName)[$key])){
                        $filter[$sourceClassName][$key] = Yii::$app->request->get($receiverClassName)[$key];
                    }
                }
                $route = array_merge($route,$filter);
            }
        }

        return parent::toRoute($route, $scheme);
    }

}

<?php

namespace core\actions;

use core\components\BaseAction;
use Yii;

class SortAction extends BaseAction
{
    public function run($attribute = 'sort')
    {
        if( $ords = Yii::$app->request->post('ords') ){

            $firstord = Yii::$app->request->post('firstord');
            $modelClass = $this->modelClass;

            foreach($ords as $k => $id){

                $modelClass::updateAll(
                    [$attribute => $firstord],
                    ['id'=>$id]
                );
                $firstord++;
            }
        }
    }
}
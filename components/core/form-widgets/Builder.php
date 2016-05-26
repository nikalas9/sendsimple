<?php

namespace core\components\FormWidgets;

use Yii;

class Builder extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        if($model->isNewRecord){
            $model->temp_id = uniqid();
        }
        Yii::$app->session[$model->temp_id] = $model->$attribute;

        return $this->render('builder',compact('form','model','attribute'));


        /*if($temp->type == 1){
            $this->render('builder',array(
                'model'=>$temp,
                'modelName'=>Yii::app()->controller->modelName,
            ));
        }
        if($temp->type == 2){
            $this->render('template',array(
                'model'=>$temp,
                'modelName'=>Yii::app()->controller->modelName,
            ));
        }*/

	}
}
<?php

namespace core\components\FormWidgets;

use Yii;

class Builder extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        if($model->temp_id == null){
            $model->temp_id = uniqid();
        }
        Yii::$app->session[$model->temp_id] = $model->$attribute;

        if ($model->mode_id == 'builder') {
            return $this->render('builder',compact('form','model','attribute'));
        } else {
            return $this->render('nicEdit',compact('form','model','attribute'));
        }
	}
}
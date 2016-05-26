<?php

namespace core\components\formWidgets;

use yii\helpers\ArrayHelper;

class CheckList extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;
        $params = $this->params;

        if($model->$attribute and is_array($model->$attribute) == false){
            $model->$attribute = explode(',',$model->$attribute);
        }
        //echo $form->field($model, $attribute, $this->fieldOptions)->checkboxList($this->params['data'],$this->options);

        return $this->render('checkList',compact('form','model','attribute','params'));
	}
}
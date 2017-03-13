<?php

namespace core\components\formWidgets;

class Select extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        if(isset($this->options['multiple']) and $this->options['multiple']){
            if(strpos($model->$attribute,',')){
                $model->$attribute = explode(',',$model->$attribute);
            }
        }

        echo $form->field($model, $attribute, $this->fieldOptions)->dropDownList($this->params['data'],$this->options);
    }
}
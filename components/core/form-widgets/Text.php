<?php

namespace core\components\formWidgets;

class Text extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        $options = ['maxlength' => 255];
        $this->options = array_merge($options,$this->options);

        if(isset($this->params['label'])){
            $label = $this->params['label'];
            return $form->field($model, $attribute, $this->fieldOptions)->textInput($this->options)->label($label);
        }

        return $form->field($model, $attribute, $this->fieldOptions)->textInput($this->options);
    }
}
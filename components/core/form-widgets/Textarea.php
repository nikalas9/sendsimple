<?php

namespace core\components\FormWidgets;

class Textarea extends BaseWidget{

    public function run() {
	
		$form = $this->form;
		$model = $this->model;
		$attribute = $this->attribute;

        $options = ['rows' => 4];
        $this->options = array_merge($options,$this->options);

        if(isset($this->params['label'])){
            $label = $this->params['label'];
            return $form->field($model, $attribute, $this->fieldOptions)->textArea($this->options)->label($label);
        }

        $model->$attribute = str_replace('<br/>',"\n",$model->$attribute);

        echo $form->field($model, $attribute, $this->fieldOptions)->textArea($this->options);
	}
}
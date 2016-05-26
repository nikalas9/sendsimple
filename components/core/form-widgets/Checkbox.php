<?php

namespace core\components\FormWidgets;

class Checkbox extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        echo $form->field($model, $attribute, $this->fieldOptions)->checkbox($this->options);
    }
}
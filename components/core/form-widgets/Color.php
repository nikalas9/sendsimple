<?php

namespace core\components\formWidgets;

class Color extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        return $this->render('color',compact('form','model','attribute'));
    }
}
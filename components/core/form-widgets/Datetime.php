<?php

namespace core\components\formWidgets;

class Datetime extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;
        $key = $this->key;

        return $this->render('datetime',compact('form','model','attribute','key'));
    }
}
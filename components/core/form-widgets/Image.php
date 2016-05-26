<?php

namespace core\components\formWidgets;

class Image extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;
        $path = $this->params['path'];
        $key = $this->key;

        return $this->render('image',compact('form','model','attribute','key','path'));
    }
}
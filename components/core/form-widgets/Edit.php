<?php

namespace core\components\FormWidgets;

//use dosamigos\ckeditor\CKEditor;
use mihaildev\ckeditor\CKEditor;

class Edit extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        echo $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => $attribute
        ]);
    }
}
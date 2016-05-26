<?php

namespace core\components\formWidgets;

use yii\helpers\ArrayHelper;

class Select2 extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;
        $fieldOptions = $this->fieldOptions;
        $options = $this->options;

        $data = $this->params['data'];

        return $this->render('select2',compact('form','model','attribute','fieldOptions','options','data'));
    }
}
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

        if(isset($this->options['multiple']) and $this->options['multiple']){
            if(!is_array($model->$attribute) and strpos($model->$attribute,',')){
                $model->$attribute = explode(',',$model->$attribute);
            }
        }

        $data = $this->params['data'];

        return $this->render('select2',compact('form','model','attribute','fieldOptions','options','data'));
    }
}
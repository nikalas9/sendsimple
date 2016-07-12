<?php

namespace core\components\formWidgets;

use yii\helpers\ArrayHelper;

class Select extends BaseWidget{

    public function run() {

        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        //$modelClass = $this->modelClass;
        //$list = ArrayHelper::map($modelClass::find()->all(),'id','name') ;

        //$options = ['prompt' => ''];
        //$this->options = array_merge($options,$this->options);

        if(isset($this->options['multiple']) and $this->options['multiple']){
            if(strpos($model->$attribute,',')){
                $model->$attribute = explode(',',$model->$attribute);
            }
        }

        echo $form->field($model, $attribute, $this->fieldOptions)->dropDownList($this->params['data'],$this->options);
    }
}
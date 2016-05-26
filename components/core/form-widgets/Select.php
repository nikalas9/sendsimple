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

        echo $form->field($model, $attribute, $this->fieldOptions)->dropDownList($this->params['data'],$this->options);
    }
}
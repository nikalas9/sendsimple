<?php

namespace core\components\formWidgets;

use yii\helpers\Html;

class Hidden extends BaseWidget{

    public function run()
    {
        $form = $this->form;
        $model = $this->model;
        $attribute = $this->attribute;

        echo Html::activeHiddenInput($model,$attribute);
    }
}
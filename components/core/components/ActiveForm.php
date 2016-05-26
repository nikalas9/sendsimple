<?php

namespace core\components;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $layout = 'horizontal';


    public $successCssClass = '';

    public $validateOnBlur = false;

    public function init()
    {
        parent::init();

        $this->id = \Yii::$app->controller->id;

        /*$this->fieldConfig['horizontalCssClasses'] = [
            'label' => 'col-sm-3',
            'offset' => 'col-sm-offset-3',
            'wrapper'=> 'col-sm-6',
        ];*/
    }
}
<?php

namespace core\components\formWidgets;

use yii\base\Widget;

class BaseWidget extends Widget{

    public $form;
    public $model;
    public $attribute;
    public $params;

    public $fieldOptions = [];
    public $options = [];

    public function init()
    {
        parent::init();

        $options = [];
        $fieldOptions = [];

        $model = $this->model;
        //$className = \yii\helpers\StringHelper::basename(get_class($this->model));
        //$attributeName = $this->attribute;

        if(isset($this->params['default']) and $this->params['default']){
            if($model->isNewRecord){
                $model->{$this->attribute} = $this->params['default'];
            }
        }

        if(isset($this->params['disable']) and $this->params['disable']){
            $options['disabled'] = true;
        }

        $this->fieldOptions = array_merge($fieldOptions,$this->fieldOptions);
        $this->options = array_merge($options,$this->options);
    }
}
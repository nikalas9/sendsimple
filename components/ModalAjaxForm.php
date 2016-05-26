<?php

namespace app\components;

class ModalAjaxForm extends \yii\bootstrap\ActiveForm
{
    public $validateOnBlur = false;

    public $validateOnChange = false;

    public $enableAjaxValidation = true;


    public $beforeSubmit;

    public $modalContentId;

    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if($this->beforeSubmit) {
            $id = $this->options['id'];
            $view = $this->getView();
            $view->registerJs("jQuery('#$id').on('beforeSubmit',". $this->beforeSubmit.");");
        }
    }
}
<?php

use yii\helpers\Html;
use core\components\ActiveForm;

$fields = $model->optionUpdate();
?>

<div class="row">
    <div class="col-sm-12">

        <?php
        $options = isset($fields['formOptions'])?$fields['formOptions']:[];
        $form = ActiveForm::begin($options); ?>

        <?php
        foreach($fields['items'] as $attribute => $params) {

            if(is_array($params)){
                $widgetName = $params['type'];
            }else{
                $widgetName = $params;
            }
            $widgetName = '\core\components\formWidgets\\'.$widgetName;

            echo $widgetName::widget([
                'form' => $form,
                'model' => $model,
                'attribute' => $attribute,
                'params'=>$params,
                'fieldOptions'=>isset($params['fieldOptions'])?$params['fieldOptions']:[],
                'options'=>isset($params['options'])?$params['options']:[],
            ]);
        }
        ?>

        <?php /* \core\components\FormWidgets\Text::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'name',
        ]) ?>

        <?php \core\components\FormWidgets\Edit::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'content',
        ]) ?>

        <?php \core\components\FormWidgets\Checkbox::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'is_customer',
        ]) */ ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

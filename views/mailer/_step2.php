<?php

use yii\helpers\Html;
use core\components\ActiveForm;

?>

<h3 class="text-center"><strong>Step 2 </strong> - Mailing Setting</h3>

<div class="row">
    <div class="col-sm-12">

        <?php $form = ActiveForm::begin(); ?>

        <?= \core\components\formWidgets\Select::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'account_id',
            'params' => [
                'data' => \app\models\Account::getDropDownList(),
                'options' => [
                    'prompt' => ''
                ]
            ]
        ]);?>

        <?= \core\components\formWidgets\Select::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'group_id',
            'params' => [
                'data' => \app\models\Group::getDropDownList(),
                'options' => [
                    'prompt' => ''
                ]
            ]
        ]);?>

        <?php
        $base = \app\models\Base::find()->with(['group'])->all();
        $baseData = \yii\helpers\ArrayHelper::map($base,'id','name','group.name');

        echo \core\components\formWidgets\Select2::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'base_ids',
            'params' => [
                'data' => $baseData,
            ],
            'options'=>[
                'multiple' => true
            ]
        ]);?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                <div class="pull-right">
                    <?= Html::submitButton('Save and continue', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

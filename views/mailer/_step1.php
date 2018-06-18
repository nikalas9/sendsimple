<?php

use yii\helpers\Html;
use core\components\ActiveForm;
?>

<h3 class="text-center"><strong>Step 1 </strong> - Mail Body</h3>

<div class="row">
    <div class="col-sm-12">

        <?php $form = ActiveForm::begin(); ?>

        <?= \core\components\formWidgets\Text::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'name',
        ]);?>

        <?= \core\components\formWidgets\Builder::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'body',
        ]);?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                <div class="pull-right">
                    <?= Html::submitButton('Create and continue', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

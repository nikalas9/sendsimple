<?php

use yii\helpers\Html;
use core\components\ActiveForm;

$module = $this->context->module;
$role = $module->model("Role");
?>

<div class="row">
    <div class="col-sm-12">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($user, 'newPassword')->passwordInput() ?>

        <?= $form->field($profile, 'full_name'); ?>

        <?= $form->field($user, 'role_id')->dropDownList($role::dropdown()); ?>

        <?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>

        <?php // use checkbox for banned_at ?>
        <?php // convert `banned_at` to int so that the checkbox gets set properly ?>
        <?php /*$user->banned_at = $user->banned_at ? 1 : 0 ?>


        <div class="form-group field-profile-full_name">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::activeCheckbox($user, 'banned_at',['labelOptions'=>['class'=>'checkbox-inline']]); ?>
                <?= Html::error($user, 'banned_at', ['class'=>'help-block help-block-error']); ?>
            </div>
        </div>

        <?= $form->field($user, 'banned_reason');*/ ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Save', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

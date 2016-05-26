<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = '/lock';

?>
<!-- MAIN CONTENT -->

<div class="lockscreen <?=Yii::$app->request->isPost?'':'animated flipInY';?>">
    <div class="logo">
        <h1 class="semi-bold"><img alt="" src="/app/img/logo-o.png"> SendSimple</h1>
    </div>
    <div style="padding: 0px;">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'validateOnBlur'=>false,
            'options' => [
                'class' => 'smart-form client-form',
            ]
        ]); ?>
            <header>
                Sign In
            </header>

            <div style="padding: 13px 13px 0px 13px;">

                <section>
                    <?= Html::activeLabel($model,'email',['class'=>'label']);?>
                    <label class="input <?php if($model->hasErrors('email')) echo 'state-error'?>"> <i class="icon-append fa fa-user"></i>
                        <?= Html::activeTextInput($model,'email');?></label>
                        <!--<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>-->
                        <em class="invalid"><?= Html::error($model,'email') ?></em>
                </section>

                <section>
                    <?= Html::activeLabel($model,'password',['class'=>'label']);?>
                    <label class="input <?php if($model->hasErrors('password')) echo 'state-error'?>"> <i class="icon-append fa fa-lock"></i>
                        <?= Html::activePasswordInput($model,'password');?></label>
                        <!--<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>-->
                        <em class="invalid"><?= Html::error($model,'password') ?></em>
                </section>

                <section>
                    <?= Html::activeCheckbox($model,'rememberMe',[
                        'labelOptions'=>[
                            'class'=>'checkbox',
                        ],
                        'label'=>'<i></i> Stay signed in',
                    ]);?>
                </section>
            </div>

            <footer>
                <button type="submit" class="btn btn-primary">
                    Sign in
                </button>
            </footer>

        <?php ActiveForm::end(); ?>

    </div>
    <p class="font-xs margin-top-5">
        Copyright SmartAdmin 2014-2020.
    </p>
</div>

<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('/web/js/plugin/jasny-bootstrap/css/jasny-bootstrap.min.css');
$this->registerJsFile('/web/js/plugin/jasny-bootstrap/js/jasny-bootstrap.min.js',['depends'=>'yii\web\JqueryAsset']);
?>

<div class="row">
    <div class="col-sm-12">

        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'import-form',
            'action' => Url::toRoute(['import/create']),
            'options' => [
                'enctype'=>'multipart/form-data',
            ],
        ]); ?>

        <?= $form->beginField($model,'file',[
            'options'=>[
                'class'=>'fileinput fileinput-new input-group',
                'data-provides'=>'fileinput'
            ]
        ]);?>
        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
            <?= Html::activeFileInput($model,'file');?>
        </span>
        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
        <?= Html::error($model, 'file');?>

        <?= $form->endField() ?>

        <?php // $form->field($model, 'file')->fileInput() ?>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>

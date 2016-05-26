<?php

use core\components\ActiveForm;
use yii\helpers\Html;
use core\helpers\Url;

$this->title = Yii::t('app','{create} creation',[
    'create'=> $model::label('action'),
]);
$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/web/js/plugin/jasny-bootstrap/css/jasny-bootstrap.min.css');
$this->registerJsFile('/web/js/plugin/jasny-bootstrap/js/jasny-bootstrap.min.js',['depends'=>'yii\web\JqueryAsset']);
?>
<div class="item-create">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">


            <div class="row">
                <div class="col-sm-12">

                    <?php $form = ActiveForm::begin([
                        'id' => 'import-form',
                        'action' => Url::toRoute(['import/create']),
                        'options' => [
                            'enctype'=>'multipart/form-data',
                        ],
                    ]); ?>

                    <?= $form->beginField($model,'file');?>
                    <?= Html::activeLabel($model,'file',['class'=>'control-label col-sm-3']);?>
                    <div class="fileinput fileinput-new input-group col-sm-6" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                            <?= Html::activeFileInput($model,'file');?>
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        <?= Html::error($model, 'file');?>
                    </div>
                    <?= $form->endField() ?>

                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-6">
                            <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>

</div>

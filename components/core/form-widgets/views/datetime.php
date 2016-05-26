<?php

use yii\helpers\Html;

$className = \yii\helpers\StringHelper::basename(get_class($model));

$datetime = explode(' ',$model->$attribute);
$date = current($datetime);
$time = next($datetime);
if(!$date){
    $date = date("Y-m-d");
}
if($time){
    $time = substr($time,0,5);
}else{
    $time = '00:00';
}


$this->registerJsFile('/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js',['depends' => 'backend\assets\AppAsset' ]);
$this->registerCssFile('/js/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',['depends' => 'backend\assets\AppAsset' ]);
$this->registerJsFile('/js/jquery.maskedinput/jquery.maskedinput.min.js',['depends' => 'backend\assets\AppAsset' ]);
$this->registerJs("
    $('input[name=\"{$className}{$key}[{$attribute}_date]\"]').datepicker({format: 'yyyy-mm-dd'});
    $('input[name=\"{$className}{$key}[{$attribute}_time]\"]').mask('99:99');
");
/*$this->registerJs("
    $('.input-datepicker').datepicker({format: 'yyyy-mm-dd'});
    $('.input-time').mask('99:99');
");*/
?>

<?= $form->beginField($model, $key.$attribute); ?>

    <?= Html::activeLabel($model,$key.$attribute,['class'=>'control-label col-sm-3']);?>
    <div class="col-sm-3">
        <div class="input-group">
            <?= Html::textInput($className.$key.'['.$attribute.'_date]',$date,['class'=>'form-control input-datepicker']);?>
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group">
            <?= Html::textInput($className.$key.'['.$attribute.'_time]',$time,['class'=>'form-control input-time']);?>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>

<?= $form->endField() ?>
<?php

use yii\helpers\Html;

$colors = array(
    'bg-color-blue',
    'bg-color-purple',
    'bg-color-green',
    'bg-color-orange',
    'bg-color-teal',
    'bg-color-magenta',
    'bg-color-greenDark',
    'bg-color-blueDark',
    'bg-color-pink',
    'bg-color-pinkDark',
    'bg-color-blueLight',
    'bg-color-yellow',
    'bg-color-orangeDark',
    'bg-color-red',
    'bg-color-redLight',
    'bg-color-greenLight',
);

$className = \yii\helpers\StringHelper::basename(get_class($model));
?>

<?= $form->beginField($model, $attribute); ?>

<?= Html::activeLabel($model, $attribute,['class'=>'control-label col-sm-3']) ?>

    <div class="col-sm-9 input-color">

        <div class="btn-group" data-toggle="buttons">
            <?php foreach($colors as $color):?>
                <label class="btn <?=$color;?> txt-color-white <?=($color==$model->$attribute?'active':'');?>">
                    <input type="radio" name="<?=$className;?>[<?=$attribute;?>]" value="<?=$color;?>" autocomplete="off" <?=($color==$model->$attribute?'checked':'');?> /> <i class="glyphicon glyphicon-ok"></i>
                </label>
            <?php endforeach;?>
        </div>

        <?= Html::error($model, $attribute) ?>
    </div>

<?= $form->endField() ?>
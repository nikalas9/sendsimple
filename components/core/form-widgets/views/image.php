<?php

use yii\helpers\Html;

?>

<?= $form->beginField($model, $key.$attribute); ?>

    <?= Html::activeLabel($model, $key.$attribute,['class'=>'control-label col-sm-3']) ?><br>

    <div class="col-sm-3">

        <?php if($model->picture):?>
            <img alt="" src="<?= $path.$model->picture;?>"/>
        <?php endif;?>

        <?= Html::activeFileInput($model, $key.$attribute) ?>

        <?= Html::error($model, $key.$attribute) ?>
    </div>

<?= $form->endField() ?>
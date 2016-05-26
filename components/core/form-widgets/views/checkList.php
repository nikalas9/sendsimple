<?php

use yii\helpers\Html;

$this->registerJs("
    $('.check-all').click(function() {
        var selector = $(this).is(':checked') ? ':not(:checked)' : ':checked';
        $('#country-container input[type=\"checkbox\"]' + selector).each(function() {
            $(this).trigger('click');
        });
    });
");
?>

<?= $form->beginField($model, $attribute); ?>
    <?= Html::activeLabel($model, $attribute,['class'=>'control-label col-sm-3']);?>
    <div class="col-sm-6">
        <div class="checkbox" id="country-container">
            <?= Html::activeCheckboxList($model, $attribute, $params['data']);?>
        </div>
        <div class="checkbox">
            <?= Html::checkbox(null, false, [
                'label' => 'Check all',
                'class' => 'check-all',
            ]);?>
        </div>
    </div>
<?= $form->endField() ?>
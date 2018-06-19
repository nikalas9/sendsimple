<?php

use yii\helpers\Html;
use core\components\ActiveForm;

$this->registerJs("
    $('.btn-send-start').click(function() {
        $.get($(this).attr('href'),function(){
            $('.btn-send-start').prop('disabled', true);
        });
        return false;
    });
");


?>

<h3 class="text-center"><strong>Step 3 </strong> - Contact List</h3>

<div class="row">
    <div class="col-sm-12">

        <p class="text-center">
            <?= Html::a('Start Send',['send-start','id'=>$letter->id],[
                'class' => 'btn btn-success btn-lg btn-send-start'
            ]);?>
        </p>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <!--<button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>-->
                <?= Html::a('Back', ['mailer/setting', 'id' => $letter->id], ['class' => 'btn btn-default']) ?>
                <div class="pull-right">
                    <?= Html::submitButton('Close', ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

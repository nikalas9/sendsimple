<?php

use yii\helpers\Html;
use core\components\ActiveForm;

/*$this->registerJs("
    $('.btn-send-start').click(function() {
        $.get($(this).attr('href'),function(){
            $('.btn-send-start').prop('disabled', true);
        });
        return false;
    });
");*/

?>

<h3 class="text-center"><strong>Step 3 </strong> - Contact List</h3>

<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-4 col-sm-offset-3">
                <?= Html::beginForm(['send-demo', 'id'=>$letter->id]); ?>
                <p>Send a test message to your email</p>
                <div class="input-group">
                    <?= Html::textInput('testEmail', Yii::$app->user->identity->email, ['class'=>'form-control']);?>
                    <div class="input-group-btn">
                        <?php echo Html::submitInput('Send test', ['class'=>'btn btn-warning']);?>
                    </div>
                </div>

                <?= Html::endForm(); ?>
            </div>
        </div>
        <hr>

        <?php if($letter->status == \app\models\Mailer::STATE_DRAFT) :?>
            <p class="text-center">
                <?= Html::a('Start Send',['send-start','id'=>$letter->id],[
                    'class' => 'btn btn-success btn-lg btn-send-start'
                ]);?>
            </p>
        <?php endif;?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <!--<button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>-->
                <?= Html::a('Back', ['mailer/setting', 'id' => $letter->id], ['class' => 'btn btn-default']) ?>
                <div class="pull-right">
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

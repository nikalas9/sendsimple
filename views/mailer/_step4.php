<?php

use app\models\Mailer;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJs("
    $('#pjax-progress').on('pjax:success', function() {
        setTimeout(progress_reload, 10000);
    });
    setTimeout(progress_reload, 10000);
    function progress_reload() {
        console.log('sdf');
        $.pjax({url: '" . \yii\helpers\Url::to(['state', 'id'=>$letter->id]) . "', container:'#pjax-progress', timeout: 10000, scrollTo: false});
    }
");

?>

<h3 class="text-center"><strong>Step 4 </strong> - Mailing Statistics</h3>

<div class="row">
    <div class="col-sm-12">

        <div class="row">

            <?php \core\components\Pjax::begin([
                    'id' => 'pjax-progress'
            ]);?>

            <div class="col-sm-6 col-sm-offset-3">

                <?php if($letter->status == Mailer::STATE_QUEUED):?>
                    <p class="lead">Letter in the queue.</p>
                <?php endif;?>

                <?php if($letter->status == Mailer::STATE_SENDING):?>
                    <p class="lead">Start sending.</p>
                    <?php if($letter->id == Yii::$app->redis->executeCommand("GET", ['mail-send_mailerId'])):?>
                        <?php
                            $stack = Yii::$app->redis->executeCommand("GET", ['mail-send_stack']);
                            $counter = Yii::$app->redis->executeCommand("GET", ['mail-send_counter']);
                            $progress = intval(($counter/$stack) * 100);
                        ?>
                        <div class="progress">
                            <div class="progress-bar bg-color-blueLight"
                                 data-transitiongoal="<?= $progress;?>" style="width: <?=$progress;?>%;" aria-valuenow="<?=80;?>">
                                <?= $progress;?> (<?=$counter;?>/<?=$stack;?>)
                            </div>
                        </div>
                    <?php endif;?>
                <?php endif;?>

                <?php if($letter->status == Mailer::STATE_PAUSE):?>
                    <p class="lead">Pause sending.</p>
                <?php endif;?>

                <?php if($letter->status == Mailer::STATE_FINISH):?>
                    <p class="lead">Finish sending.</p>
                    <script type="text/javascript">
                        location.href = '<?= Url::to(['view','id'=>$letter->id]);?>';
                    </script>
                <?php endif;?>

                <p class="text-center">
                    <?php if ($letter->status == Mailer::STATE_QUEUED):?>
                        <?= Html::a('Send Cancel',['send-cancel','id'=>$letter->id],[
                            'class' => 'btn btn-warning btn-lg btn-send-start'
                        ]);?>
                    <?php elseif($letter->status == Mailer::STATE_SENDING):?>
                        <?= Html::a('Send Pause',['send-pause','id'=>$letter->id],[
                            'class' => 'btn btn-warning btn-lg btn-send-start'
                        ]);?>
                    <?php elseif($letter->status == Mailer::STATE_PAUSE):?>
                        <?= Html::a('Send Play',['send-play','id'=>$letter->id],[
                            'class' => 'btn btn-primary btn-lg btn-send-start'
                        ]);?>
                    <?php endif;?>
            </div>
            <?php \core\components\Pjax::end();?>
        </div>
        <hr>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <!--<button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>-->
                <?= Html::a('Back', ['mailer/send-order', 'id' => $letter->id], ['class' => 'btn btn-default']) ?>
                <div class="pull-right">
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

use app\models\Mailer;
use core\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use sammaye\audittrail\AuditTrail;

use core\helpers\Url;
use core\helpers\GhostHtml;

$this->registerJsFile('/web/js/plugin/iframeResizer/iframeResizer.min.js',['depends' => 'app\assets\AppAsset']);
$this->registerJsFile('/app/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js',['depends' => 'app\assets\AppAsset']);
$this->registerJs("
    iFrameResize();
");

$this->title = Yii::t('app','{model}: {name}',[
    'model'=>$model::label('model'),
    'name'=> isset($model->name) ? $model->name : $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = isset($model->name) ? $model->name : $model->id;

$option = $model->optionView($model);

$countStack = $model->getCountStack();
if ($countStack) {
    $countSend = $model->getCountSend();
    $pSend = intval(($countSend / $countStack) * 100);
    $countDeliver = $model->getCountDeliver();
    $pDeliver = intval(($countDeliver / $countStack) * 100);
    $countOpen = $model->getCountOpen();
    $pOpen = intval(($countOpen / $countStack) * 100);
    $countSpam = $model->getCountSpam();
    $pSpam = intval(($countSpam / $countStack) * 100);
}
?>
<div class="company-view">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <?php if($countStack):?>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="well well-sm well-light text-center">
                    <div class="easy-pie-chart txt-color-blue easyPieChart" data-percent="<?=$pSend;?>" data-pie-size="120">
                        <span class="percent percent-sign txt-color-blue font-lg semi-bold"><?=$pSend;?></span>
                    </div>
                    <span class="easy-pie-text"> Send<br><?=$countSend;?> </span>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="well well-sm well-light text-center">
                    <div class="easy-pie-chart txt-color-green easyPieChart" data-percent="<?=$pDeliver;?>" data-pie-size="120">
                        <span class="percent percent-sign txt-color-green font-lg semi-bold"><?=$pDeliver;?></span>
                    </div>
                    <span class="easy-pie-text"> Deliver<br><?=$countDeliver;?> </span>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="well well-sm well-light text-center">
                    <div class="easy-pie-chart txt-color-orange easyPieChart" data-percent="<?=$pOpen;?>" data-pie-size="120">
                        <span class="percent percent-sign txt-color-orange font-lg semi-bold"><?=$pOpen;?></span>
                    </div>
                    <span class="easy-pie-text"> Open<br><?=$countOpen;?> </span>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="well well-sm well-light text-center">
                    <div class="easy-pie-chart txt-color-black easyPieChart" data-percent="<?=$pSpam;?>" data-pie-size="120">
                        <span class="percent percent-sign txt-color-black font-lg semi-bold"><?=$pSpam;?></span>
                    </div>
                    <span class="easy-pie-text"> Unsubscribe<br><?=$countSpam;?> </span>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?php // Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>

                <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-default']) ?>

                <?= Html::a('Send ail again', ['add-mail', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']) ?>

                <?= Html::a('Add to template', ['add-template', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']) ?>

                <?php if(in_array($model->status, [Mailer::STATE_DRAFT, Mailer::STATE_CANCEL, Mailer::STATE_FINISH]) ):?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger pull-right',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this row?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif;?>
            </p>

            <?php if($model->error_message):?>
                <div class="alert alert-danger fade in">
                    <strong>Error!</strong> <?=$model->error_message;?>
                </div>
            <?php endif;?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $option['items'],
                'options'=>[
                    'class'=>'table table-striped table-bordered detail-view',
                ]
            ]) ?>

        </div>
    </div>

</div>

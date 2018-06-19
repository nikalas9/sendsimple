<?php

use app\models\Mailer;
use core\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use sammaye\audittrail\AuditTrail;

use core\helpers\Url;
use core\helpers\GhostHtml;

$this->title = Yii::t('app','{model}: {name}',[
    'model'=>$model::label('model'),
    'name'=> isset($model->name) ? $model->name : $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = isset($model->name) ? $model->name : $model->id;

$option = $model->optionView($model);
?>
<div class="company-view">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>

                <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-default']) ?>

                <?php if(in_array($model->status, [Mailer::STATE_DRAFT, Mailer::STATE_CANCEL]) ):?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger pull-right',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this row?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif;?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $option['items'],
                'options'=>[
                    'class'=>'table table-striped table-bordered detail-view',
                    'style'=>'max-width:800px;'
                ]
            ]) ?>

        </div>
    </div>

</div>

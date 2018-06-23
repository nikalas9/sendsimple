<?php

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

                <?= Html::a('Create', ['create'], ['class' => 'btn btn-sm btn-success']) ?>

                <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-default']) ?>

                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger pull-right',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this row?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $option['items'],
                'options'=> (isset($option['widgetOption']) ? $option['widgetOption'] : [
                    'class'=>'table table-striped table-bordered detail-view',
                    'style'=>'max-width:800px;'
                ])
            ]) ?>


            <!--<h3>Loggable</h3>-->

            <?php
            /*$criteria = AuditTrail::find();
            $criteria->where([
                'model'=>$model::className(),
                'model_id'=>$model->id,
            ]);
            $criteria->orderBy([
                'stamp' => SORT_DESC
            ]);

            echo yii\grid\GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $criteria,
                    'pagination' => [
                        'pageSize' => 100,
                    ]
                ]),
                'columns' => [
                    [
                        'label' => 'Author',
                        'value' => function($model, $index, $widget){
                            return $model->user ? $model->user->username : "";
                        }
                    ],
                    [
                        'attribute' => 'model',
                        'value' => function($model, $index, $widget){
                            $p = explode('\\', $model->model);
                            return end($p);
                        }
                    ],
                    'model_id',
                    'action',
                    [
                        'label' => 'field',
                        'value' => function($model, $index, $widget){
                            return $model->getParent()->getAttributeLabel($model->field);
                        }
                    ],
                    'old_value',
                    'new_value',
                    [
                        'label' => 'Date Changed',
                        'value' => function($model, $index, $widget){
                            return date("d-m-Y H:i:s", $model->stamp);
                        }
                    ]
                ]
            ]);*/?>

        </div>
    </div>

</div>

<?php

use yii\helpers\Url;
use core\components\GridView;
use core\components\Pjax;
use core\components\gridPageSize\GridPageSize;
use core\helpers\Html;

//use webvimark\modules\UserManagement\models\User;
use app\models\User;

$this->title = $searchModel::label('list');
$this->params['breadcrumbs'][] = $this->title;

$option = $searchModel->optionIndex($searchModel);

?>
<div class="row">
    <div class="col-sm-12">

        <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::a('Clear', ['clear'], [
                            'class' => 'btn btn-sm btn-warning pull-right',
                            'data' => [
                                'confirm' => 'Are you sure you want to clear log?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>


                <?php Pjax::begin([
                    'id'=> str_replace('/','-',Yii::$app->controller->id) . '-grid-pjax',
                ]) ?>

                <?= GridView::widget([
                    'id'=> str_replace('/','-',Yii::$app->controller->id) . '-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn'
                        ],
                        [
                            'class' => \core\components\gridColumns\DateTimeRangeColumn::className(),
                            'attribute' => 'log_time',
                            'value' => function ($model) {
                                $ms = (string)$model->log_time;
                                $ms = substr($ms, strpos($ms, '.') + 1, 3);
                                return date("d M, H:i:s", $model->log_time) . '.' . $ms;
                            },
                        ],
                        [
                            'attribute' => 'category',
                            'value' => function ($model) {
                                return $model->category;
                            },
                            'headerOptions' => [
                                'style' => 'width:140px'
                            ],
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'message',
                            'value' => function ($model) {
                                return str_replace("\n", '<br>', $model->message);
                            },
                            'format' => 'html',
                        ]
                    ],
                    'rowOptions' => function ($model, $index, $widget, $grid) {
                        if ($model->level == 1) {
                            return ['class' => 'danger'];
                        }
                        if ($model->level == 2) {
                            return ['class' => 'warning'];
                        }
                    },
                    'layout' => '{items}
        <div class="row">
            <div class="col-sm-6">
                <div class="dataTables_info">{summary}</div>
            </div>
             <div class="col-sm-6">
                <div class="dataTables_paginate paging_simple_numbers">{pager}</div>
            </div>
        </div>',
                ]); ?>

                <?php Pjax::end() ?>

            </div>
        </div>

    </div>
</div>
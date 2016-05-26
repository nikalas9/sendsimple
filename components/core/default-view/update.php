<?php

use yii\helpers\Html;
use core\helpers\Url;

$this->title = Yii::t('app','Editing {update}: {name}',[
    'update'=> mb_strtolower(  $model::label('action'), 'utf-8' ),
    'name'=> isset($model->name) ? $model->name : $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index']) ];
$this->params['breadcrumbs'][] = ['label' => isset($model->name) ? $model->name : $model->id, 'url' => Url::toRoute(['view','id'=>$model->id]) ];
$this->params['breadcrumbs'][] = 'Editing';

?>
<div class="item-update">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?php
            if(file_exists(Yii::$app->controller->getViewPath().'/_form.php')){
                echo $this->renderFile(Yii::$app->controller->getViewPath().'/_form.php', ['model' => $model]);
            }
            else{
                echo $this->render('_form', ['model' => $model]);
            }
            ?>
        </div>
    </div>

</div>

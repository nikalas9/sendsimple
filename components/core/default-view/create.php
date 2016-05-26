<?php

use yii\helpers\Html;
use core\helpers\Url;

$this->title = Yii::t('app','{create} creation',[
    'create'=> $model::label('action'),
]);
$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-create">

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

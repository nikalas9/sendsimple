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

        <?php if(Yii::$app->session->hasFlash('error')):?>
            <div class="alert alert-danger fade in">
                <button data-dismiss="alert" class="close">
                    ×
                </button>
                <i class="fa-fw fa fa-times"></i>
                <strong>Error!</strong> <?=Yii::$app->session->getFlash('error');?>
            </div>
        <?php endif;?>

        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-6">
                        <?php if(isset(Yii::$app->controller->actions()['create'])):?>
                            <p>
                                <?= Html::a(
                                    '<span class="glyphicon glyphicon-plus-sign"></span> Create',
                                    //$option['link'] ? array_merge(['create'],$option['link']) : ['create'],
                                    ['create'],
                                    ['class' => 'btn btn-success']
                                ) ?>
                            </p>
                        <?php endif;?>
                    </div>

                    <div class="col-sm-6 text-right">
                        <?php if( User::canRoute( Url::toRoute('grid-page-size') ) ):?>
                            <?= GridPageSize::widget() ?>
                        <?php endif;?>
                    </div>
                </div>

                <?php Pjax::begin([
                    'id'=> str_replace('/','-',Yii::$app->controller->id) . '-grid-pjax',
                ]) ?>

                <?= GridView::widget([
                    'id'=> str_replace('/','-',Yii::$app->controller->id) . '-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $option['items'],
                ]); ?>

                <?php Pjax::end() ?>

            </div>
        </div>

    </div>
</div>

<?php
/*yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalLgSimpleHeader'],
    'header' => '<span id="modalLgSimpleHeaderTitle"></span>',
    'id' => 'modalLgSimple',
    //'ajaxSubmit' => true,
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo '<div id="modalLgSimpleContent"></div>';
yii\bootstrap\Modal::end();

yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalMdSimpleHeader'],
    'header' => '<span id="modalMdSimpleHeaderTitle"></span>',
    'id' => 'modalMdSimple',
    //'ajaxSubmit' => true,
    'size' => 'modal-md',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo '<div id="modalMdSimpleContent"></div>';
yii\bootstrap\Modal::end();

yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalLgHeader'],
    'header' => '<span id="modalLgHeaderTitle"></span>',
    'id' => 'modalLg',
    //'ajaxSubmit' => true,
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
    'footer' => '<button onclick="$(\'#modalLg\').modal(\'hide\');" class="btn btn-default" type="button">Cancel</button>
        '. Html::a('Save', '#', [
            'class' => 'btn btn-primary',
            'onclick' => "$('#modalLg').find('form').submit()",
        ])
]);
echo '<div id="modalLgContent"></div>';
yii\bootstrap\Modal::end();

yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalMdHeader'],
    'header' => '<span id="modalMdHeaderTitle"></span>',
    'id' => 'modalMd',
    //'ajaxSubmit' => true,
    'size' => 'modal-md',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
    'footer' => '<button onclick="$(\'#modalMd\').modal(\'hide\');" class="btn btn-default" type="button">Cancel</button>
        '. Html::a('Save', '#', [
            'class' => 'btn btn-primary',
            'onclick' => "$('#modalMd').find('form').submit()",
        ])
]);
echo '<div id="modalMdContent"></div>';
yii\bootstrap\Modal::end();*/
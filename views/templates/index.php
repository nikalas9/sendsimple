<?php

use yii\helpers\Url;
use core\components\GridView;
use core\components\Pjax;
use core\components\gridPageSize\GridPageSize;
use yii\helpers\Html;

//use webvimark\modules\UserManagement\models\User;
use app\models\User;

$this->registerJsFile("/web/js/plugin/fancyBox2/jquery.mousewheel-3.0.6.pack.js",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile("/web/js/plugin/fancyBox2/jquery.fancybox.css");
$this->registerJsFile("/web/js/plugin/fancyBox2/jquery.fancybox.js",['depends' => 'app\assets\AppAsset']);
$this->registerJs("
$('.preview').fancybox();
");

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
                        <p>
                            <?= Html::a(
                                '<span class="glyphicon glyphicon-plus-sign"></span> Create',
                                '#',
                                [
                                    'class' => 'btn btn-success',
                                    'onclick' => "$('#modalMdSimple').modal();"
                                ]
                            ) ?>
                        </p>
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
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalMdSimpleHeader'],
    'header' => '<span id="modalMdSimpleHeaderTitle"><h4>Template Create</h4></span>',
    'id' => 'modalMdSimple',
    //'ajaxSubmit' => true,
    'size' => 'modal-md',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]); ?>
<div id="modalMdSimpleContent">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <?= Html::a('Mail Builder',
                [
                    'create',
                    'Templates[mode_id]' => 'builder'
                ], [
                    'class'=>'btn btn-default btn-lg'
                ]);?>
        </div>
        <div class="btn-group">
            <?= Html::a('Text Message', ['create'],[
                    'class'=>'btn btn-default btn-lg'
                ]);?>
        </div>
    </div>
</div>
<?php yii\bootstrap\Modal::end();
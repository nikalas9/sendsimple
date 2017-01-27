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
                    <div class="col-sm-6">
                        <p>
                            <?= Html::button('Import file', [
                                'data-link' => Url::to(['import/create']),
                                'data-modal' => 'modalMd',
                                'data-title' => 'Import file',
                                'class' => 'showModalButton btn btn-success'
                            ]); ?>
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
            'onclick' => "$('#modalMd').find('form').submit(); return false;",
        ])
]);
echo '<div id="modalMdContent"></div>';
yii\bootstrap\Modal::end();
<?php

use core\components\GridView;
use core\components\Pjax;
use core\components\gridPageSize\GridPageSize;
use yii\helpers\Url;
use yii\helpers\Html;

//use webvimark\modules\UserManagement\models\User;
use app\models\User;

$module = $this->context->module;
$user = $module->model("User");
$role = $module->model("Role");

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12">

        <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <?= Html::a(
                                '<span class="glyphicon glyphicon-plus-sign"></span> Create User',
                                ['create'],
                                ['class' => 'btn btn-success']
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
                    'columns' => [
                        [
                            'class' => \core\components\gridColumns\SerialColumn::className(),
                            'attribute'=>'id',
                        ],
                        [
                            'class' => \core\components\gridColumns\StatusColumn::className(),
                            'attribute'=>'status',
                            'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'status', 'id'=>'_id_']),
                        ],
                        'created_at:datetime',
                        /*[
                            'attribute' => 'status',
                            'label' => Yii::t('user', 'Status'),
                            'filter' => $user::statusDropdown(),
                            'value' => function($model, $index, $dataColumn) use ($user) {
                                $statusDropdown = $user::statusDropdown();
                                return $statusDropdown[$model->status];
                            },
                        ],*/
                        'username',
                        'email',
                        'profile.full_name',
                        // 'password',
                        // 'auth_key',
                        // 'access_token',
                        // 'logged_in_ip',
                        // 'logged_in_at',
                        // 'created_ip',
                        // 'updated_at',
                        // 'banned_at',
                        // 'banned_reason',

                        [
                            'attribute' => 'role_id',
                            'label' => Yii::t('user', 'Role'),
                            'filter' => $role::dropdown(),
                            'value' => function($model, $index, $dataColumn) use ($role) {
                                $roleDropdown = $role::dropdown();
                                return $roleDropdown[$model->role_id];
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions'=>['width'=>'100px'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'buttonOptions'=>['class'=>'btn btn-default btn-xs']
                        ]
                    ]
                ]); ?>

                <?php Pjax::end() ?>

            </div>
        </div>

    </div>
</div>

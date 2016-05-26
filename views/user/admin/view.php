<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use sammaye\audittrail\AuditTrail;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $user->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(Yii::t('user', 'Update'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('user', 'Delete'), ['delete', 'id' => $user->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('user', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $user,
                'attributes' => [
                    'id',
                    'role_id',
                    'status',
                    'email:email',
                    'username',
                    'profile.full_name',
                    //'password',
                    //'auth_key',
                    //'access_token',
                    'logged_in_ip',
                    'logged_in_at',
                    'created_ip',
                    'created_at',
                    'updated_at',
                    //'banned_at',
                    //'banned_reason',
                ],
                'options'=>[
                    'class'=>'table table-striped table-bordered detail-view',
                    'style'=>'max-width:800px;'
                ]
            ]) ?>

        </div>
    </div>
</div>

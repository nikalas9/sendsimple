<?php

use yii\helpers\Html;
use core\helpers\Url;

$this->title = Yii::t('app','{create} creation',[
    'create'=> 'Mail',
]);
$this->params['breadcrumbs'][] = ['label' => 'Mailer', 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-create">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">

                    <div class="form-bootstrapWizard">
                        <ul class="bootstrapWizard form-wizard">
                            <li class="active">
                                <a href="#"  aria-expanded="true">
                                    <span class="step">1</span>
                                    <span class="title">Mail Body</span>
                                </a>
                            </li>
                            <li class="">
                                <span class="step">3</span> <span class="title">Mailing Setting</span>
                            </li>
                            <li class="">
                                <span class="step">4</span> <span class="title">Contact List</span>
                            </li>
                            <li class="">
                                <span class="step">4</span> <span class="title">Mailing Statistics</span>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <br>
            <?= $this->render('_step1', ['model' => $model]); ?>
        </div>
    </div>

</div>

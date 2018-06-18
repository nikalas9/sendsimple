<?php

use yii\helpers\Html;
use core\helpers\Url;

$this->title = Yii::t('app','Editing {update}: {name}',[
    'update'=> mb_strtolower(  $letter::label('action'), 'utf-8' ),
    'name'=> isset($letter->name) ? $letter->name : $letter->id,
]);

$this->params['breadcrumbs'][] = ['label' => $letter::label('list'), 'url' => Url::toRoute(['index']) ];
$this->params['breadcrumbs'][] = ['label' => isset($letter->name) ? $letter->name : $letter->id, 'url' => Url::toRoute(['view','id'=>$letter->id]) ];
$this->params['breadcrumbs'][] = 'Editing';

?>
<div class="item-update">

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
                                <a href="#"> <span class="step">3</span> <span class="title">Mailing Setting</span> </a>
                            </li>
                            <li class="">
                                <a href="#"> <span class="step">4</span> <span class="title">Contact List</span> </a>
                            </li>
                            <li class="">
                                <a href="#"> <span class="step">4</span> <span class="title">Mailing Statistics</span> </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <br>
            <?= $this->render($step, compact('model','letter')); ?>
        </div>
    </div>

</div>

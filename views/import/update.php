<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use core\helpers\Url;
use core\components\ActiveForm;

$this->title = Yii::t('app','Editing {update}: {name}',[
    'update'=> mb_strtolower(  $model::label('action'), 'utf-8' ),
    'name'=> isset($model->name) ? $model->name : $model->id ,
]);

$this->params['breadcrumbs'][] = ['label' => $model::label('list'), 'url' => Url::toRoute(['index']) ];
$this->params['breadcrumbs'][] = ['label' => isset($model->name) ? $model->name : $model->id, 'url' => Url::toRoute(['view','id'=>$model->id]) ];
$this->params['breadcrumbs'][] = 'Editing';

?>
<div class="item-update">

    <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= \core\components\formWidgets\Select2::widget([
                        'form' => $form,
                        'model' => $model,
                        'attribute' => 'base_id',
                        'params'=>[
                            'data'=>ArrayHelper::map(\app\models\Base::find()->with(['group'])->all(),'id','name','group.name'),
                        ],
                        'options'=>[
                            'prompt'=>'',
                        ]
                    ]);?>


                    <?php
                    if($listData):?>
                        <?= $form->beginField($model,'column',[
                            'options'=>[
                                'class'=>'col-md-offset-1',
                            ]
                        ]);?>

                        <p class="lead">Пожалуйста, укажите каким данным о контакте соответсвуют колонки из файла</p>

                        <table class="table table-bordered table-striped smart-form" style="width:auto;">
                            <?php
                            $clientParams = ArrayHelper::map(\app\models\ClientsParam::find()->all(),'alias','name');
                            $columnList = ArrayHelper::merge([
                                'email'=>'E-mail',
                            ],$clientParams);

                            echo '<tr class="warning">';
                            foreach($listData[1] as $key => $row){
                                echo '<td><label class="select">';

                                echo Html::dropDownList('Files[column]['.$key.']',false,$columnList,[
                                    'prompt'=>'пропустить',
                                    'class'=>'column form-control input-sm',
                                ]);
                                echo '<i></i></label></td>';
                            }
                            echo '</tr>';

                            foreach($listData as $key => $line){
                                if($line){
                                    echo '<tr>';
                                    foreach($line as $row){
                                        echo '<td>'.$row.'</td>';
                                    }
                                    echo '</tr>';
                                }
                                if($key == 7) break;
                            }

                            $this->registerJs("
                            $('.column').change(function(){
                                var columnValue = $(this).val();
                                var columnName = $(this).attr('name');
                                if( columnValue ){
                                    $.each( $('.column'), function( key, obj ) {
                                        if( $(obj).val() == columnValue && $(obj).attr('name') != columnName ){
                                            $(obj).val('');
                                        }
                                    });
                                }
                            });");
                            ?>
                        </table>
                        <?= Html::error($model,'column',['class'=>'help-block help-block-error']);?>
                        <?= $form->endField() ?>
                    <?php endif;?>


                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-6">
                            <button onclick="window.history.back();" class="btn btn-default" type="button">Cancel</button>
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>

</div>

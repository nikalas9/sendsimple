<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile('/web/js/plugin/iframeResizer/iframeResizer.min.js',['depends' => 'app\assets\AppAsset']);

$this->registerJs("

$('.openBuilder').click(function(){

    if($(this).hasClass('btn-info')){

        $('#templateViewer').hide();
        $('#templateEdit').show();
        var iframe = document.getElementById('templateEdit');
        iframe.src = $(this).attr('href');

        $('.openBuilder').removeClass('btn-info');
        $('.openBuilder').addClass('btn-warning');
        $('.openBuilder').text('Save');

        $('.form-group button').attr('disabled',true);
    } else {
    
        var content = $('#templateEdit').contents().find('#templateBody').html();
        $('#Mailer_body').val(content);

        $.post('" . Url::toRoute(['letter/update', 'key'=>$model->temp_id]) . "',{'content':content}, function(html){
            $('#templateEdit').hide();
            $('#templateViewer').show();
            var iframe = document.getElementById('templateViewer');
            iframe.src = iframe.src;

            $('.openBuilder').removeClass('btn-warning');
            $('.openBuilder').addClass('btn-info');
            $('.openBuilder').text('Change');

            $('.form-group button').removeAttr('disabled');
        });
    }
    return false;
});
iFrameResize();
");

echo Html::activeHiddenInput($model,'body', [
    'id' => 'Mailer_body'
]);
echo Html::activeHiddenInput($model,'temp_id');
echo Html::activeHiddenInput($model,'mode_id');
?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <p class="lead"><?= Yii::t('app','Mail preview');?>
            <?php
            echo Html::a(Yii::t('app','Edit letter'),
                Url::toRoute(['letter/nic-edit','key'=>$model->temp_id]),
                array(
                    'class'=>'btn btn-info openBuilder pull-right',
                )
            );
            ?>
        </p>
    </div>
</div>

<iframe width="100%" frameborder="0" vspace="0" hspace="0" scrolling="no" src="<?= Url::toRoute(['letter/view','key'=>$model->temp_id]);?>" id="templateViewer">
</iframe>

<iframe style="display: none;" width="100%" frameborder="0" vspace="0" hspace="0" scrolling="no" src="#" id="templateEdit">
</iframe>
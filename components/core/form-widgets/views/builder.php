<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile('/web/js/plugin/iframeResizer/iframeResizer.min.js',['depends' => 'app\assets\AppAsset']);

$this->registerJsFile("/web/js/plugin/fancyBox2/jquery.mousewheel-3.0.6.pack.js",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile("/web/js/plugin/fancyBox2/jquery.fancybox.css");
$this->registerJsFile("/web/js/plugin/fancyBox2/jquery.fancybox.js",['depends' => 'app\assets\AppAsset']);

$this->registerJs("

dialogClose = false;

$('.openBuilder').fancybox({
    autoSize    : false,
    width		: 1000,
    height      : '100%',
    beforeClose    : function() {
        $('#fancybox-frame').contents().find('.nav-block-top').remove();
        $('#fancybox-frame').contents().find('.nav-block-bottom').remove();
        $('#fancybox-frame').contents().find('.edittable').removeAttr('contenteditable');

        if(dialogClose){
            dialogClose = false;
            return true;
        }
        else{

            $.SmartMessageBox({
                title : '".Yii::t('app','To complete the work with the designer?')."',
                buttons : '[".Yii::t('app','Cancel')."][".Yii::t('app','Close without saving')."][".Yii::t('app','Save Changes')."]'
            }, function(ButtonPressed) {
                if (ButtonPressed === '".Yii::t('app','Save Changes')."') {

                    var builderFrame=document.getElementById('fancybox-frame');
                    builderFrame.contentWindow.closeCkeditors();

                    var blockList = $('#fancybox-frame').contents().find('.row-block');
                    /*var containerBackgroundColor = $('#fancybox-frame').contents().find('body').css('background-color');*/
                    var container = $('#fancybox-frame').contents().find('body');
                    var style = str_replace('\"',\"'\",$(container).attr('style'));

                    var content = '<div id=\"container\" style=\"'+style+'\"><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"644\" class=\"content\"><tbody>';
                    $.each(blockList, function( i, val ) {
                        content += '<tr><td class=\"row-block\" align=\"left\" valign=\"top\" border=\"0\" class=\"td\">'+$(val).html()+'</td></tr>';
                    });
                    content += '</tbody></table></div>';

                    $('#Mailer_body').val(content);

                    $.post('".Url::toRoute(['letter/update','key'=>$model->temp_id])."',{'content':content},function(html){
                        $('#mailer-body').val(content);

                        var iframe = document.getElementById('templateViewer');
                        iframe.src = iframe.src;

                        dialogClose = true;
                        $.fancybox.close();
                    });
                }
                if (ButtonPressed === '".Yii::t('app','Close without saving')."') {
                    dialogClose = true;
                    $.fancybox.close();
                }
            });
            return false;
        }
    }
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
                Url::toRoute(['letter/builder','key'=>$model->temp_id]),
                array(
                    'class'=>'btn btn-info openBuilder pull-right',
                    'data-fancybox-type'=>'iframe',
                    'style'=>'margin:5px;',
                )
            );
            ?>
        </p>
    </div>
</div>


<iframe width="100%" frameborder="0" vspace="0" hspace="0" scrolling="no" src="<?= Url::toRoute(['letter/view','key'=>$model->temp_id]);?>" id="templateViewer">
</iframe>

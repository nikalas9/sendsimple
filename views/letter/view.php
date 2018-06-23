<?php

use yii\web\View;

$this->registerJsFile("/web/js/plugin/iframeResizer/iframeResizer.contentWindow.min.js");

if ($content) {
    $this->registerJsFile('/web/js/plugin/html2canvas.min.js');
    $this->registerJs("
     html2canvas(document.body, {
      onrendered: function(canvas) {

        var canvasEx = document.createElement('canvas');
        var width = 800;
        var height = Math.round(canvas.height*800 / canvas.width);

        canvasEx.width = width;
        canvasEx.height = height;
        var ctx = canvasEx.getContext('2d');
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, width, height);
        ctx.drawImage(canvas, 0, 0, width, height);

        var dataURL = canvasEx.toDataURL('image/jpeg', 0.9);
        $.post('" . \yii\helpers\Url::toRoute(['letter/preview','key'=>$key]) . "',{'data':dataURL});
      }
    });
    ", View::POS_READY, 'preview');

    echo $content;
}
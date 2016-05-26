<?php

use app\assets\BuilderAsset;

BuilderAsset::register($this);

$this->registerJsFile("/web/js/plugin/iframeResizer/iframeResizer.contentWindow.min.js");

$this->beginPage();

if($content){
    /*$this->registerJsFile('/public/web/js/plugin/html2canvas.min.js',CClientScript::POS_END);
    $cs->registerScript('html2canvas',"
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
        $.post('/index.php?r=temp/preview&pk={$model->id}',{'data':dataURL});
      }
    });
    ",CClientScript::POS_READY);*/

    echo $content;
}
$this->endPage();
<?php

use yii\web\View;
use mihaildev\elfinder\ElFinder;

$this->registerJsFile("/web/js/plugin/iframeResizer/iframeResizer.contentWindow.min.js");
$this->registerJsFile('/web/js/plugin/nicEdit/nicEdit.js');

$managerUrl = ElFinder::getManagerUrl('elfinder',[
    'filter' => 'image',
    'path' => 'template/' . $key,
]);

$this->registerJs("
    fileBrowserUrl = '".$managerUrl."';
", View::POS_BEGIN, 'builder_init');

$this->registerJs("
    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('templateBody');
    });
", View::POS_READY, 'template');

?>

<div id="templateBody" style="max-height:500px;  background-color: #fff; border: 1px solid #999; min-height: 300px; padding: 10px; margin-top:6px; overflow-y: auto;"><?= $content;?></div>

<?php

use mihaildev\elfinder\ElFinder;

$this->registerJsFile('/web/js/plugin/iframeResizer/iframeResizer.min.js');
$this->registerJs("
iFrameResize();
");

echo ElFinder::widget([
    //'language'         => 'ru',
    //'controller'       => 'letter', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'path' => $key,
    'callbackFunction' => new \yii\web\JsExpression('function(file, id){
        var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
        window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
        window.close();
    }') // id - id виджета*/
]);
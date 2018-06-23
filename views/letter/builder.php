<?php

use yii\web\View;
use app\assets\BuilderAsset;
use mihaildev\elfinder\ElFinder;

BuilderAsset::register($this);

$managerUrl = ElFinder::getManagerUrl('elfinder',[
    'filter' => 'image',
    'path' => 'template/'.$key,
]);
$this->registerJs("
    blankLink = '".Yii::$app->params['baseUrl']."/public/builder/images/blank.gif';
    baseUrl = '".Yii::$app->params['baseUrl']."';
    builderLanguage = 'en';
    includeFontAwesome = true;
    fileBrowserUrl = '".$managerUrl."';
", View::POS_HEAD, 'builder_init');

$htmlbuttonsJs = "CKEDITOR.config.htmlbuttons = [";
$htmlbuttonsJs .= '
    {
        name:"button_general",
        title:"Маркеры",
        items : [
            {
                name:"button1",
                title:"Веб-версия письма",
                html:"<a target=\"_blank\" href=\"{$link.web}\">Веб-версия письма</a>"
            },
            {
                name:"button4",
                title:"Название группы",
                html:"{$group.name}"
            },
            {
                name:"button5",
                title:"E-mail Подписчика",
                html:"{$contact.email}"
            },
            {
                name:"button3",
                title:"Адресс отписки",
                html:"{$link.unsubscribe}"
            }
        ]
    }
]';
$this->registerJs($htmlbuttonsJs,View::POS_END,'htmlbuttons');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Builder</title>

    <?php $this->head() ?>
</head>

<body style="<?= $style;?>">
<?php $this->beginBody() ?>

    <div id="nav-panel">
        <div id="nav-panel-body">
            <ul class="nav nav-pills nav-top" role="tablist">
                <!--<li class="prevBackup disabled" role="presentation"><a href="javascript:" onclick="prevBackup();"><span class="glyphicon glyphicon-circle-arrow-left"></span></a></li>
                <li class="nextBackup disabled" role="presentation"><a href="javascript:" onclick="nextBackup();"><span class="glyphicon glyphicon-circle-arrow-right"></span></a></li>
                <li style="float:right;" role="presentation"><a id="changeBackgroundMail" href="javascript:"><?= Yii::t('app','Change background color');?></a></li>-->

                <li style="float:right;" role="presentation"><a id="changeBackgroundImageBody" href="javascript:"><span class="glyphicon glyphicon-picture"></a></li>
                <li style="float:right;" role="presentation"><a id="changeBackgroundColorBody" href="javascript:"><span class="glyphicon glyphicon-tint"></span></a></li>
            </ul>
            <div id="toolbarLocation"></div>
        </div>
    </div>

    <div id="container">
        <div id="sortable">
            <?php
            if($content){
                echo $content;

                $this->registerJs("
                    $('.edittable').attr('contenteditable',true);
                    $.each( $('.edittable'), function( i, val ) {
                        $( $('.edittable')[i] ).attr('id',generateRandomId());
                    });
                ");
            }
            else{

                $this->registerJs("

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('web');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('header1','".Yii::t('app','The name of the company website')."');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('4','".Yii::t('app','The main idea of writing')."');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('9','".Yii::t('app','Good afternoon, {$contact.first_name}<br><br>Insert here the text of your message. In order to have your delivery was effective, try to follow these tips:<ul><li> Think about what you want to achieve this mailing </li><li> Think about who your recipients </li><li> write so as if you are applying to one person</li></ul>')."');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('1','".Yii::t('app','Always say good-bye.')."');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('contact1','');

                    $('#sortable').append('<div class=\"row-block\"><div class=\"content-block\"></div></div>');
                    blockUpdateRow = $('#sortable').children('.row-block').filter(':last');
                    blockUpdateSet('footer','');
                ");
            }
            ?>

        </div>
    </div>


   <!--<div id="update-dialog-modal" title="<?= Yii::t('app','Change block type');?>">
        <ul class="nav nav-pills nav-stacked" role="tablist">
            <li class="type1" role="presentation"><a href="javascript:" onclick="blockUpdateSet('1','');"><?= Yii::t('app','Text');?></a></li>
            <li class="type2" role="presentation"><a href="javascript:" onclick="blockUpdateSet('2','');"><?= Yii::t('app','Picture');?></a></li>
            <li class="type3" role="presentation"><a href="javascript:" onclick="blockUpdateSet('3','');"><?= Yii::t('app','Separator');?></a></li>
            <li class="type4" role="presentation"><a href="javascript:" onclick="blockUpdateSet('4','');"><?= Yii::t('app','Heading 1');?></a></li>
            <li class="type5" role="presentation"><a href="javascript:" onclick="blockUpdateSet('5','');"><?= Yii::t('app','Heading 2');?></a></li>
            <li class="type6" role="presentation"><a href="javascript:" onclick="blockUpdateSet('6','');"><?= Yii::t('app','Heading 3');?></a></li>
            <li class="type7" role="presentation"><a href="javascript:" onclick="blockUpdateSet('7','');"><?= Yii::t('app','Banner');?></a></li>
            <li class="type8" role="presentation"><a href="javascript:" onclick="blockUpdateSet('8','');"><?= Yii::t('app','Text - Text');?></a></li>
            <li class="type9" role="presentation"><a href="javascript:" onclick="blockUpdateSet('9','');"><?= Yii::t('app','Text Picture');?></a></li>
            <li class="type10" role="presentation"><a href="javascript:" onclick="blockUpdateSet('10','');"><?= Yii::t('app','Picture Text');?></a></li>
            <li class="type11" role="presentation"><a href="javascript:" onclick="blockUpdateSet('11','');"><?= Yii::t('app','Picture Picture');?></a></li>
            <li class="type12" role="presentation"><a href="javascript:" onclick="blockUpdateSet('12','');"><?= Yii::t('app','Text Text Text');?></a></li>
            <li class="type13" role="presentation"><a href="javascript:" onclick="blockUpdateSet('13','');"><?= Yii::t('app','Picture Picture Picture');?></a></li>
            <li class="type14" role="presentation"><a href="javascript:" onclick="blockUpdateSet('14','');"><?= Yii::t('app','Block');?></a></li>
            <li class="type15" role="presentation"><a href="javascript:" onclick="blockUpdateSet('15','');"><?= Yii::t('app','Block Block');?></a></li>
            <li class="type16" role="presentation"><a href="javascript:" onclick="blockUpdateSet('16','');"><?= Yii::t('app','Block Block Block');?></a></li>
            <li class="news" role="presentation"><a href="javascript:" onclick="blockUpdateSet('news','');"><?= Yii::t('app','News block');?></a></li>
        </ul>
    </div>-->

   <div id="update-dialog-modal" title="<?= Yii::t('app','Change block type');?>">

       <div id="tabs">
           <ul>
               <li><a href="#tabs-1">Основные блоки</a></li>
               <li><a href="#tabs-2">Элемент: Тень</a></li>
               <li><a href="#tabs-3">Дайджест</a></li>
           </ul>
           <div id="tabs-1">

               <ul class="changeBlock">
                   <li class="type7">
                       <a href="javascript:" onclick="blockUpdateSet('7','');">
                           <img alt="" src="/builder/images/block/banner.png"/>
                           <span><?= Yii::t('app','Banner');?></span>
                       </a>
                   </li>
                   <li class="type9">
                       <a href="javascript:" onclick="blockUpdateSet('9','');">
                           <img alt="" src="/builder/images/block/text-img.png"/>
                           <span><?= Yii::t('app','Text Picture');?></span>
                       </a>
                   </li>
                   <li class="type10">
                       <a href="javascript:" onclick="blockUpdateSet('10','');">
                           <img alt="" src="/builder/images/block/img-text.png"/>
                           <span><?= Yii::t('app','Picture Text');?></span>
                       </a>
                   </li>

                   <li class="type1">
                       <a href="javascript:" onclick="blockUpdateSet('1','');">
                           <img alt="" src="/builder/images/block/text1.png"/>
                           <span><?= Yii::t('app','Text');?></span>
                       </a>
                   </li>
                   <li class="type8">
                       <a href="javascript:" onclick="blockUpdateSet('8','');">
                           <img alt="" src="/builder/images/block/text2.png"/>
                           <span><?= Yii::t('app','Text - Text');?></span>
                       </a>
                   </li>
                   <li class="type12">
                       <a href="javascript:" onclick="blockUpdateSet('12','');">
                           <img alt="" src="/builder/images/block/text3.png"/>
                           <span><?= Yii::t('app','Text 3');?></span>
                       </a>
                   </li>

                   <li class="type2">
                       <a href="javascript:" onclick="blockUpdateSet('2','');">
                           <img alt="" src="/builder/images/block/img1.png"/>
                           <span><?= Yii::t('app','Picture');?></span>
                       </a>
                   </li>
                   <li class="type11">
                       <a href="javascript:" onclick="blockUpdateSet('11','');">
                           <img alt="" src="/builder/images/block/img2.png"/>
                           <span><?= Yii::t('app','Picture Picture');?></span>
                       </a>
                   </li>
                   <li class="type13">
                       <a href="javascript:" onclick="blockUpdateSet('13','');">
                           <img alt="" src="/builder/images/block/img3.png"/>
                           <span><?= Yii::t('app','Picture 3');?></span>
                       </a>
                   </li>

                   <li class="type4">
                       <a href="javascript:" onclick="blockUpdateSet('4','');">
                           <img alt="" src="/builder/images/block/header1.png"/>
                           <span><?= Yii::t('app','Heading 1');?></span>
                       </a>
                   </li>
                   <li class="type5">
                       <a href="javascript:" onclick="blockUpdateSet('5','');">
                           <img alt="" src="/builder/images/block/header2.png"/>
                           <span><?= Yii::t('app','Heading 2');?></span>
                       </a>
                   </li>
                   <li class="type6">
                       <a href="javascript:" onclick="blockUpdateSet('6','');">
                           <img alt="" src="/builder/images/block/header3.png"/>
                           <span><?= Yii::t('app','Heading 3');?></span>
                       </a>
                   </li>

                   <li class="type14">
                       <a href="javascript:" onclick="blockUpdateSet('14','');">
                           <img alt="" src="/builder/images/block/block1.png"/>
                           <span><?= Yii::t('app','Block');?></span>
                       </a>
                   </li>
                   <li class="type15">
                       <a href="javascript:" onclick="blockUpdateSet('15','');">
                           <img alt="" src="/builder/images/block/block2.png"/>
                           <span><?= Yii::t('app','Block Block');?></span>
                       </a>
                   </li>
                   <li class="type16">
                       <a href="javascript:" onclick="blockUpdateSet('16','');">
                           <img alt="" src="/builder/images/block/block3.png"/>
                           <span><?= Yii::t('app','Block 3');?></span>
                       </a>
                   </li>

                   <li class="type3">
                       <a href="javascript:" onclick="blockUpdateSet('3','');">
                           <img alt="" src="/builder/images/block/sp.png"/>
                           <span><?= Yii::t('app','Separator');?></span>
                       </a>
                   </li>
               </ul>
           </div>

           <div id="tabs-2">
               <ul class="changeBlock">

                   <li class="shadow1">
                       <a href="javascript:" onclick="blockUpdateSet('shadow1','');">
                           <img alt="" src="/builder/images/block/shadow.png"/>
                       </a>
                   </li>
                   <li class="shadow2">
                       <a href="javascript:" onclick="blockUpdateSet('shadow2','');">
                           <img alt="" src="/builder/images/block/shadow2.png"/>
                       </a>
                   </li>
                   <li class="shadow3">
                       <a href="javascript:" onclick="blockUpdateSet('shadow3','');">
                           <img alt="" src="/builder/images/block/shadow3.png"/>
                       </a>
                   </li>
                   <li class="shadow4">
                       <a href="javascript:" onclick="blockUpdateSet('shadow4','');">
                           <img alt="" src="/builder/images/block/shadow4.png"/>
                       </a>
                   </li>
                   <li class="shadow5">
                       <a href="javascript:" onclick="blockUpdateSet('shadow5','');">
                           <img alt="" src="/builder/images/block/shadow5.png"/>
                       </a>
                   </li>
                   <li class="shadow6">
                       <a href="javascript:" onclick="blockUpdateSet('shadow6','');">
                           <img alt="" src="/builder/images/block/shadow6.png"/>
                       </a>
                   </li>
                   <li class="shadow7">
                       <a href="javascript:" onclick="blockUpdateSet('shadow7','');">
                           <img alt="" src="/builder/images/block/shadow7.png"/>
                       </a>
                   </li>
                   <li class="shadow8">
                       <a href="javascript:" onclick="blockUpdateSet('shadow8','');">
                           <img alt="" src="/builder/images/block/shadow8.png"/>
                       </a>
                   </li>
                   <li class="shadow9">
                       <a href="javascript:" onclick="blockUpdateSet('shadow9','');">
                           <img alt="" src="/builder/images/block/shadow9.png"/>
                       </a>
                   </li>
               </ul>
           </div>

           <div id="tabs-3">

               <ul class="changeBlock">
                   <li class="typenews">
                       <a href="javascript:" onclick="blockUpdateSet('news','');">
                           <img alt="" src="/builder/images/block/news1.png"/>
                       </a>
                   </li>
               </ul>
           </div>

       </div>
    </div>

    <div id="cp-dialog-modal" title="<?= Yii::t('app','Change the background color block');?>">
        <span class="cp-onclick" style="display: inline-block; vertical-align: top;"></span>
    </div>

    <div id="cp2-dialog-modal" title="<?= Yii::t('app','Change background color');?>">
        <span class="cp2-onclick" style="display: inline-block; vertical-align: top;"></span>
    </div>

    <div id='injection_site'></div>

    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
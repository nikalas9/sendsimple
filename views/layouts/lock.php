<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\LockAsset;

LockAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html id="lock-page" lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="/app/img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/app/img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700&subset=cyrillic">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

    </head>


    <body class="desktop-detected">
    <?php $this->beginBody() ?>

    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- MAIN CONTENT -->
            <?= $content ?>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN PANEL -->

    <!--================================================== -->

    <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
    <script data-pace-options='{ "restartOnRequestAfter": true }' src="/app/js/plugin/pace/pace.min.js"></script>

    <!--[if IE 8]>
    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>
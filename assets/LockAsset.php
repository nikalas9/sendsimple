<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LockAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    // #CSS Links
    public $css = [
        // Basic Styles
        //'css/bootstrap.min.css',
        'web/css/font-awesome/css/font-awesome.min.css',
        // SmartAdmin Styles : Caution! DO NOT change the order
        'web/css/smartadmin-production-plugins.css',
        'web/css/smartadmin-production.css',
        // SmartAdmin RTL Support
        'app/css/smartadmin-skins.min.css',
        'app/css/smartadmin-rtl.min.css',
        //'app/css/lockscreen.min.css',
        'web/css/lock.css',
    ];

    public $js = [
        'web/js/libs/jquery-ui-1.10.4.js',
        // IMPORTANT: APP CONFIG
        'app/js/app.config.js',
        // JS TOUCH : include this plugin for mobile drag / drop touch events
        'app/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        // JQUERY MASKED INPUT
        'app/js/plugin/masked-input/jquery.maskedinput.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}

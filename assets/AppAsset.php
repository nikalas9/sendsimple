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
class AppAsset extends AssetBundle
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

        'web/css/style.css',
    ];

    public $js = [
        'web/js/libs/jquery-ui-1.10.4.js',
        // IMPORTANT: APP CONFIG
        'app/js/app.config.js',
        // JS TOUCH : include this plugin for mobile drag / drop touch events
        'app/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        // BOOTSTRAP JS
        //'js/bootstrap/bootstrap.min.js',
        // CUSTOM NOTIFICATION
        'web/js/notification/SmartNotification.js',
        // JARVIS WIDGETS
        'app/js/smartwidgets/jarvis.widget.min.js',
        // SPARKLINES
        'app/js/plugin/sparkline/jquery.sparkline.min.js',
        // JQUERY MASKED INPUT
        'app/js/plugin/masked-input/jquery.maskedinput.min.js',
        // JQUERY SELECT2 INPUT
        'app/js/plugin/select2/select2.min.js',
        // JQUERY UI + Bootstrap Slider
        'app/js/plugin/bootstrap-slider/bootstrap-slider.min.js',
        // browser msie issue fix
        'app/js/plugin/msie-fix/jquery.mb.browser.min.js',
        // FastClick: For mobile devices
        'app/js/plugin/fastclick/fastclick.min.js',
        // MAIN APP JS FILE
        'app/js/app.min.js',
        // Voice command : plugin
        'app/js/speech/voicecommand.min.js',
        // script
        'web/js/ajax-modal-popup.js',
        'web/js/script.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
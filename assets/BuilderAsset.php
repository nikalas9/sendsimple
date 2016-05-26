<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BuilderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    // #CSS Links
    public $css = [
        // jquery
        'builder/js/jquery-ui/jquery-ui.css',
        // colorpicker
        'builder/js/colorpicker/jquery.colorpicker.css',
        // bootstrap
        'builder/js/bootstrap-nav/css/bootstrap.css',
        // builder
        'builder/css/buider.css',
        'builder/css/mail.css',
    ];

    public $js = [
        'builder/js/jquery-ui/jquery-ui.js',
        // colorpicker
        'builder/js/colorpicker/jquery.colorpicker.js',
        // html2canvas
        //'builder/js/html2canvas.min.js',
        // ckeditor
        'builder/ckeditor/ckeditor.js',
        'builder/ckeditor/config.js',
        // builder
        'builder/js/builder.js',
        'builder/js/builder.en.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        Yii::$app->assetManager->bundles['yii\\web\\JqueryAsset'] = [
            'sourcePath' => null,
            'js' => [
                '/builder/js/jquery-1.11.1.min.js',
            ]
        ];
    }
}
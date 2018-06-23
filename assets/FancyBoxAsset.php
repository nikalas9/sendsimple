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
class FancyBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    // #CSS Links
    public $css = [
        'web/js/plugin/fancyBox2/jquery.fancybox.css',
    ];

    public $js = [
        'web/js/plugin/fancyBox2/jquery.mousewheel-3.0.6.pack.js',
        'web/js/plugin/fancyBox2/jquery.fancybox.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
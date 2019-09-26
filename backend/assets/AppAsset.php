<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    // public $css = [
    //     'css/site.css',
    // ];
    // public $js = [
    // ];
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'fonts/circular-std/style.css'
    ];
    public $js = [
    ];
    public $depends = [
        // 'common\assets\CommonAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'phpnt\slimscroll\SlimScrollAsset',
    ];
}

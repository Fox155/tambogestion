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
        'yii\bootstrap\BootstrapAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        //'phpnt\slimscroll\SlimScrollAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        // 'common\assets\BowerAsset',
    ];
}

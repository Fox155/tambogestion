<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Admin backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/simple-sidebar.css'
    ];
    public $js = [
    ];
    public $depends = [
        'common\assets\CommonAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        // 'phpnt\slimscroll\SlimScrollAsset',
    ];
}
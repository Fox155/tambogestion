<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common';
    public $js = [
        'js/Principal.js',
    ];
    public $css = [
        'css/app.css'
    ];
    public $depends = [
        'yii\widgets\MaskedInputAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'common\assets\NpmAsset',
        'common\assets\BowerAsset',
    ];
}
<?php

namespace backend\assets;

use yii\web\AssetBundle;

class VacasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/Vacas.js'
    ];
    public $depends = [
    ];
}
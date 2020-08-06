<?php

namespace common\assets;

use yii\web\AssetBundle;

class NpmAsset extends AssetBundle
{
    public $sourcePath = '@npm/';
    public $js = [];
    // public $css = [
    //     'vuetify/dist/vuetify.css'
    // ];
    // public function init()
    // {
    //     parent::init();

    //     $this->js[] = 'vuetify/dist/vuetify.js';
    // }
}

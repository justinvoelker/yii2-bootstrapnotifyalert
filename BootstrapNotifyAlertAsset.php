<?php

namespace justinvoelker\bootstrapnotifyalert;

use yii\web\AssetBundle;

class BootstrapNotifyAlertAsset extends AssetBundle
{
    public $sourcePath = '@vendor/justinvoelker/yii2-bootstrapnotifyalert/assets';
    public $css = [
        'animate.css',
    ];
    public $js = [
        'bootstrap-notify.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}

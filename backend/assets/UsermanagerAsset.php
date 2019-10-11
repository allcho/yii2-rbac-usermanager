<?php

namespace allcho\rbac\backend\assets;

use yii\web\AssetBundle;


class UsermanagerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/allcho/yii2-rbac-usermanager/backend';
    public $css = [

    ];
    public $js = [
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

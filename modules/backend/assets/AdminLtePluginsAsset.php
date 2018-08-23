<?php
/**
 * Created by PhpStorm.
 * Author: Leonidax
 * Date: 2017/2/16
 * Time: 16:38
 * Email:wap@iamlk.cn
 */

namespace app\modules\backend\assets;
use yii\web\AssetBundle;

class AdminLtePluginsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';
    public $js = [
        'plugins/slimScroll/jquery.slimscroll.min.js',
    ];
}
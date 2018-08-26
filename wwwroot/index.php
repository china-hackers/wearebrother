<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$app = new yii\web\Application($config);
$app->language = Yii::$app->session->get('language', 'zh-CN');
$app->run();
exit;
$w = urlencode('可以');
$url = 'http://dict-co.iciba.com/api/dictionary.php?type=json&w=good&key=9F153B01D3161642CB56C1BB78D4E50E';
echo file_get_contents($url);

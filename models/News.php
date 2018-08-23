<?php
/**
 * Created by PhpStorm.
 * Author: Leonidax
 * Date: 2016/12/9
 * Time: 10:17
 * Email:wap@iamlk.cn
 */

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\Expression;
use Yii;

class News extends Content
{
    static $currentType = Parent::TYPE_NEWS;
}
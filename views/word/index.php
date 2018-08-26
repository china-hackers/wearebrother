<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
var_dump($data);
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <form id="word" class="form-horizontal" action="/word/index" method="get" role="form">
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <input type="text" name="w" value="">
                <button type="submit" class="btn btn-primary" name="login-button">查询</button>
            </div>
        </div>

    </form>

    <div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>
</div>

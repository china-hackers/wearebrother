<?php
/**
 * Created by PhpStorm.
 * Author: Leonidax
 * Date: 2016/12/7
 * Time: 15:25
 * Email:wap@iamlk.cn
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\backend\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name;
$fieldOptions1 = [
    'options' => ['class' => 'username-field'],
    'template' => "{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'password-field'],
    'template' => "{input}<!--span class='glyphicon glyphicon-lock form-control-feedback'></span-->"
];
$fieldOptions3 = [
        'options' => ['class'=>'']
];
?>

<div id="container">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableClientValidation' => false,
    ]); ?>
    <div class="login"><?= Yii::$app->name ?></div>
    <div class="username-text">登录用户:</div>
    <div class="password-text">登录密码:</div>
    <?= $form->field($model, 'username',$fieldOptions1)->label(false)->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password',$fieldOptions2)->label(false)->passwordInput() ?>
    <?= $form->field($model, 'rememberMe',$fieldOptions3)->checkbox(['value'=>1,'template'=>"{input}\n{beginLabel}\n{labelTitle}\n{endLabel}"]); ?>
    <div class="forgot-usr-pwd">Forgot <a href="#">username</a> or <a href="#">password</a>?</div>
    <?= Html::submitInput('登录') ?>
    <?php ActiveForm::end(); ?>
</div>
<div id="footer">
    技术支持 Powered by <a href="<?= \Yii::$app->params['authorUrl'] ?>" target="_blank" title="<?= \Yii::$app->params['author'] ?>"><?= \Yii::$app->params['author'] ?></a>
</div>

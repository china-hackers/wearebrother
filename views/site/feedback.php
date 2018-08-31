<?php
use kartik\form\ActiveForm;
if(Yii::$app->session->getFlash('contactFormSubmitted')):
    $list = Yii::$app->session->getFlash('contactFormSubmitted');
    $alert = '';
    $message = '';
    if(is_array($list)){
        $message = '<div style="align-content: center;">';
        foreach($list as $li){
            $message .= '<p style="color: red;">'.$li.'</p>';
        }
        $message .= '</div>';
    }else{
        $alert = $list;
    }
    Yii::$app->session->setFlash('contactFormSubmitted', false);
    if($alert):
?>
<script>
    alert('<?=$alert?>');
</script>
<?php endif;?>
<?php if($message):?>
<?=$message?>
<?php endif;endif; ?>
<!---内容开始-->
<ul class="ly_box">
    <div class="ly_text">
        <p>标题：</p>
        <p>姓名：</p>
        <p>电话：</p>
        <p>邮箱：</p>
        <P>内容：</p>
    </div>
    <div class="ly_input">
        <?php $form = ActiveForm::begin([
        'id' => 'feedback',]);?>
        <input name="feedback[subject]" type="text">
        <input name="feedback[name]" type="text">
        <input name="feedback[phone]" type="text">
        <input name="feedback[email]" type="text">
        <textarea name="feedback[body]" class="ly_content"></textarea>
        <button type="submit">提交</button>
        <?php ActiveForm::end();?>
    </div>
</ul>
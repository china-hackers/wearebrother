<!---内容开始-->
<ul class="news_box">
    <div class="news_title_box">
        <h1 class="news_title"><?=$model->title?></h1>
        <P class="news_date">发布时间：<?=date('Y-m-d',$model->created_at)?>     来源：北川卫计委</P>
    </div>
    <div class="news_text">
        <?=$model->detail->detail?>
    </div>
</ul>
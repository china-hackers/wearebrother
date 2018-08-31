<ul class="obj_box">
    <?php foreach($cates as $cate):?>
    <li class="leftIn">
        <a href="/site/list/id/<?=$cate->id?>"><img src="<?=$cate->image?>"/></a>
        <h1><?=$cate->name?></h1>
        <P><?=$cate->description?></P>
    </li>
    <?php endforeach;?>
</ul>
<img class="obj_pic leftIn1" src="/images/title1.png"/>
<a class="obj_box2 rightIn1" href="">
    <?=$des?>...<span>[详情]</span></a>
<img class="obj_pic" src="/images/title2.png"/>
<div class="obj_box3">
    <?php foreach($list as $li):?>
    <a href="/site/news/id/<?=$li->id?>"><?=$li->title?></a>
    <?php endforeach;?>
    <a href="">更多>></a>
</div>
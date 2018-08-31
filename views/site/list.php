<ul class="news_box">
    <?php
    foreach($list as $i=>$li):
        if($i>9) break;
    ?>
    <li class="news_show"><a href="/site/news/id/<?=$li->id?>"><?=$li->title?></a></li>
    <?php endforeach; ?>
    <?php if(count($list)>9):?>
    <!--隐藏部分-->
    <div class="hidden_box3">
        <?php
            foreach($list as $li=>$li):
                if($i<10) continue;
        ?>
        <li class="news_show"><a href="/site/news/id/<?=$li->id?>"><?=$li->title?></a></li>
        <?php endforeach; ?>
    </div>
    <!--隐藏部分结束-->
    <li id="more_but" onclick="javascript:this.innerHTML=(this.innerHTML=='显示更多'?'收起':'显示更多');">显示更多</li>
    <script>
        $("#more_but").click(function(){
            $(".hidden_box3").slideToggle(1000);
        });
    </script>
    <?php endif;?>
</ul>
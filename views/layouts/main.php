<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\widgets\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Carousel;
use yii\helpers\Url;

AppAsset::register($this);
$carouselItems = [];
if (isset($this->params['adList'])) {
    foreach ($this->params['adList'] as $item) {
        $carouselItems[] = [
            'content' => '<a href="' . $item['link'] . '" target="_black"><img src="' . $item['image'] . '" style="width:100%"/></a>',
//        'caption'=>'<h4>'.$item['title'].'</h4>',
        ];
    }
}
$brandLabel = Yii::$app->name;
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?=$this->title?>-<?=$brandLabel?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache" /><!--只是或者请求的消息不能缓存-->
    <meta name="viewport" content="width=device-width" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><!--强制让文档与设备的宽度保持 1:1 ；
    文档最大的宽度比列是1.0（ initial-scale 初始刻度值和 maximum-scale 最大刻度值）；user-scalable 定义用户是否可以手动缩放（ no 为不缩放），使页面固定设备上面的大小；-->
    <meta name="apple-mobile-web-app-capable" content="yes" /><!--网站开启对 web app 程序的支持-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" /><!--（改变顶部状态条的颜色）-->
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/modernizr.custom.js"></script>
    <script type="text/javascript" src="/js/jquery.dlmenu.js"></script>
    <script src='/js/hhSwipe.js' type="text/javascript"></script>
</head>
<body>
<div class="wrap_box">
    <!--头部部分开始-->
    <div class="nav_box">
        <a class="back_but" href=""><img src="/images/home_icon.png"/></a>
        <p class="nav_title"><?=$this->title?></P>
        <div class="menu">
            <!--<img class="menu_but" src="images/menu_icon.png"/>-->
            <div id="dl-menu" class="dl-menuwrapper">
                <button id="dl-menu-button">Open Menu</button>
                <ul class="dl-menu">
                    <li><a href="/">网站首页</a></li>
                    <li><a class="sub_menu" href="">业务资讯</a>
                        <ul class="dl-submenu">
                            <li class="dl-back"><a href="#">返回上一级</a></li>
                            <?php foreach($this->params['cates'] as $cate):?>
                            <li><a href="/site/list/id/<?=$cate->id?>"><?=$cate->name?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <li><a href="/site/contact">联系我们</a></li>
                    <li><a href="/site/about">关于我们</a></li>
                    <li><a href="/site/feedback">留言板</a></li>
                </ul>
            </div>
            <script type="text/javascript">
                $(function(){
                    $( '#dl-menu' ).dlmenu();
                });
            </script>
        </div>
    </div>
    <!--头部部分结束-->
    <!--banner图开始-->
    <div class="addWrap">
        <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
                <?php foreach($this->params['ads'] as $ad):?>
                <div><a href="<?=$ad->link?>"><img class="img-responsive" src="<?=$ad->image?>"/></a></div>
                <?php endforeach;?>
            </div>
        </div>
        <!--按转换按钮开始-->
        <ul id="position">
            <?php foreach($this->params['ads'] as $i => $ad):?>
            <li <?php if($i==0) echo 'class="cur"'; ?> ></li>
            <?php endforeach; ?>
        </ul>
        <!--按转换按钮结束-->
    </div>
    <script type="text/javascript">
        var bullets = document.getElementById('position').getElementsByTagName('li');
        var banner = Swipe(document.getElementById('mySwipe'), {
            auto: 4000,
            continuous: true,
            disableScroll:false,
            callback: function(pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = ' ';
                }
                bullets[pos].className = 'cur';
            }
        })
    </script>
    <!--banner结束-->
    <?= $content ?>
    <!--内容结束-->
    <!--页尾开始-->
    <div class="footer_box">
        <a href="/"><img src="/images/fot_icon1.png"/>首页</a>
        <a href="/site/feedback"><img src="/images/fot_icon3.png"/>留言板</a>
        <a href="/site/about"><img src="/images/fot_icon2.png"/>关于我们</a>
        <a href="/site/contact"><img src="/images/fot_icon4.png"/>联系我们</a>
    </div>
    <!--页尾结束-->
</div>
</body>
</html>
<?php $this->endPage() ?>

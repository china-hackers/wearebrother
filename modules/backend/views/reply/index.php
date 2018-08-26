<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
$gridview = [
    'layout'=>"{summary}\n{items}\n{pager}",
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'options' => ['style' => 'width:50px']
        ],
        ['attribute'=>'content_id',
            'value'=>'content.title',
            'label'=>'所属文章',
        ],
        'detail',
        'heart',
        'created:datetime',
        ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
    ],
];
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('评论管理', ['index']) ?></li>
        </ul>
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget($gridview); ?>
        </div>
    </div>
</div>

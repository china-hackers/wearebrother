<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = ['label' => '用户反馈', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$gridview = [
    'model' => $model,
    'options' => ['class' => 'table table-striped'],
    'attributes' => [
        ['attribute'=>'content_id',
            'vlaue'=>'content.title',
            'label'=>'所属文章',
        ],
        [
        'attribute' => 'detail',
        'captionOptions' => ['style' => 'width:100px'],
        ],
        'detail',
        'heart',
        'created:datetime',
    ],
];
?>
<div class="content-view">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('用户反馈', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('详情', ['#']) ?></li>
        </ul>
        <div class="tab-content">

            <p>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget($gridview) ?>

        </div>
    </div>
</div>

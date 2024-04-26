<?php

use app\models\Work;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<div class="work-index">



    <?= Nav::widget([
        'options' => ['class' => 'cabinet-links navbar-nav flex-row align-items-center ms-auto'],
        'items' => [
            ['label' => 'Мои работы', 'url' => ['/cabinet/index'], 'options' => ['class' => 'link-item']],
            ['label' => 'Регистрация', 'url' => ['/cabinet/collections'], 'options' => ['class' => 'link-item']],
        ]
    ])
        ?>
    <?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>
    <div class="cabinet-menu">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
        <?= Html::a('Создать пост', ['work/create'], ['class' => 'btn button-main-active']) ?>
    </div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget) {
        return
            Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]);

    },
    ]) ?>

    <?php Pjax::end(); ?>

</div>
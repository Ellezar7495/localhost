<?php

use app\models\Like;
use app\models\Subscribe;
use app\models\User;
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
<div class="author-index">

    <?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>
    <div class="cabinet-menu">
    <div class="header-label"><?= Html::encode($model->login) ?></div>
        <?= !Subscribe::findOne(['author_id' => $model->id, 'user_id' => Yii::$app->user->id]) 
        ? Html::a(
            'Подписаться',
            ['/cabinet/subscribe', 'id' => $model->id, 'url' => Url::current()],
            ['class' => 'btn button-main-active', 'data' => ['method' => 'post'], 'style' => ''])
        : Html::a(
            'Отписаться',
            ['/cabinet/delete-subscribe', 'id' => $model->id, 'url' => Url::current()],
            ['class' => 'button-main nav-item', 'data' => ['method' => 'post'], 'style' => '']
        ) ?>
    </div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => '_item-author'
    ]) ?>

    <?php Pjax::end(); ?>

</div>
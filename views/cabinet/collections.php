<?php

use app\models\Like;
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
<div class="work-collections">



    <?= Nav::widget([
        'options' => ['class' => 'cabinet-links navbar-nav flex-row align-items-center ms-auto'],
        'items' => [
            ['label' => 'Мои работы', 'url' => ['/cabinet/index'], 'options' => ['class' => 'link-item']],
            ['label' => 'Коллекции', 'url' => ['/cabinet/collections'], 'options' => ['class' => 'link-item']],
            ['label' => 'Профиль', 'url' => ['/cabinet/profile'], 'options' => ['class' => 'link-item']],
            ['label' => 'Понравившиеся', 'url' => ['/cabinet/liked'], 'options' => ['class' => 'link-item']],
            Yii::$app->user->identity?->role_id == 2 
            ? ['label' => 'Панель админитсратора', 'url' => ['/admin'], 'options' => ['class' => 'link-item']]
            : '',
        ]
    ])
        ?>
    <?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>
    <div class="cabinet-menu">
        <?= $this->render('_searchCollections', ['model' => $searchModel, 'dataProvider' => $dataProvider]); ?>

    </div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => '_item'
    ]) ?>

    <?php Pjax::end(); ?>

</div>
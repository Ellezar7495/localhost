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
<div class="profile-index">



    <?= Nav::widget([
        'options' => ['class' => 'cabinet-links navbar-nav flex-row align-items-center ms-auto'],
        'items' => [
            ['label' => 'Мои работы', 'url' => ['/cabinet/index'], 'options' => ['class' => 'link-item']],
            ['label' => 'Коллекции', 'url' => ['/cabinet/collections'], 'options' => ['class' => 'link-item']],
            ['label' => 'Профиль', 'url' => ['/cabinet/profile'], 'options' => ['class' => 'link-item']],
        ]
    ])
        ?>

    <div class="profile-form">
        <?= $this->render('_form_profile', [
            'model' => $model,
        ]) ?>

    </div>
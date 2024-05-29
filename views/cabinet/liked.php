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
<div class="work-liked">



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
    <div class="header-label">
        <?= ListView::widget([
            'dataProvider' => $dataProviderSubscribes,
            'itemOptions' => ['class' => 'sub-avatar-border'],
            'summary' => '',
            'itemView' => function ($index, $user, $author) {
                return Html::a(Html::img('../web/uploads/' . User::findOne(['id' => Subscribe::findOne(['id' => $user])->author_id])->img_url, ['class' => 'sub-avatar']), ['/cabinet/author', 'id' => Subscribe::findOne(['id' => $user])->author_id], ['data' => ['method' => 'post']]);

            }
        ]) ?>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => '_item'
    ]) ?>

</div>
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
        'itemView' => function ($model, $key, $index, $widget) {
        return
            Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]) .
            '<div class="work-objects d-flex flex-row justify-content-between align-items-center">' .
            '<div class="d-flex flex-row" style="gap:15px">' . Html::img('../web/uploads/' . User::findOne(['id' => $model->user_id])->img_url, ['class' => 'work-avatar']) . '<div class="work-label d-flex align-items-center">' . $model->title . '</div>' . '</div>' .
            ((!Like::find()->where(['user_id' => Yii::$app->user->id, 'work_id' => $model->id])->exists()) ?
                Html::a(
                    Html::img('../web/uploads/like.svg'),
                    ['/like/create', 'work_id' => $model->id, 'url' => Url::current()],
                    ['class' => 'like button-text text-decoration-none', 'data' => ['method' => 'post'], 'style' => '']
                )
                :
                Html::a(
                    Html::img('../web/uploads/like-active.svg'),
                    ['/like/delete', 'work_id' => $model->id, 'url' => Url::current()],
                    ['class' => 'like button-text text-decoration-none', 'data' => ['method' => 'post'], 'style' => '']
                )
            ) .
            '</div>'
        ;

    },
    ]) ?>

    <?php Pjax::end(); ?>

</div>
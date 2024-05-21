<?php

use app\models\Like;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="work-view">

    <div class="work-attributes">
        <?= Html::img('../web/uploads/' . Html::encode($model->img_url), ['class' => 'work-img']) ?>
        <div class="attributes d-flex flex-row justify-content-between">
            <div class="header-label"><?= Html::encode($this->title) ?></div>
            
            <?= ((!Like::find()->where(['user_id' => Yii::$app->user->id, 'work_id' => $model->id])->exists()) ?
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
            ); ?>
        </div>
        <div class="work-comments">
            <?= ListView::widget([
                'dataProvider' => $dataProviderComments,
                'itemOptions' => ['class' => 'work-item-author'],
                'summary' => '',
                'itemView' => function ($model, $key, $index, $widget) {
                    return
                        'to';
                },
            ]) ?>
        </div>
    </div>
    <div class="work-advice">
        <div class="header-label">От этого же автора</div>
        <div class="work-author-blocks">
            <?= ListView::widget([
                'dataProvider' => $dataProviderAuthor,
                'itemOptions' => ['class' => 'work-item-author'],
                'summary' => '',
                'itemView' => function ($model, $key, $index, $widget) {
                    return
                        Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]);
                },
            ]) ?>
        </div>
        <div class="work-category-blocks">

        </div>
    </div>

</div>
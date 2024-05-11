<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="work-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="work-attributes">
        <?= Html::img('../web/uploads/' . Html::encode($model->img_url), ['class' => 'work-img']) ?>
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="work-advice">
        <div class="work-author-blocks">
            <?= ListView::widget([
                'dataProvider' => $dataProviderAuthor,
                'itemOptions' => ['class' => 'work-item'],
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content',
            'user_id',
            'created_at',
            'img_url:url',
        ],
    ]) ?>

</div>
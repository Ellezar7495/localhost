<?php

use app\models\Like;
use app\models\User;
use app\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="work-view">

    <div class="work-attributes">
        <?= Html::img('../web/uploads/' . Html::encode($model->img_url), ['class' => 'work-img']) ?>
        <div class="attributes d-flex flex-row justify-content-between">
            <div class="d-flex flex-row" style="gap:15px">
                <?=
                    Html::a(Html::img('../web/uploads/' . User::findOne(['id' => $model->user_id])->img_url, ['class' => 'work-avatar']), ['/cabinet/author', 'id' => $model->user_id], ['data' => ['method' => 'post']])
                    ?>
                <div class="work-label d-flex align-items-center"><?= Html::encode($model->title) ?> </div>
            </div>
            <div class="d-flex flex-row">
                <? Pjax::begin(['id' => 'addCollection']) ?>
                <?= $this->render('_collection_form.php', ['modelCollection' => $modelCollection, 'model' => $model]) ?>
                <? Pjax::end() ?>
                <?php Pjax::begin(['id' => 'like']) ?>
                <?= ((!Like::find()->where(['user_id' => Yii::$app->user->id, 'work_id' => $model->id])->exists()) ?
                    Html::a(
                        Html::img('../web/uploads/like.svg'),
                        ['', 'id' => $model->id],
                        [
                            'id' => 'like',
                            'class' => 'like button-text text-decoration-none',
                            'data' => [
                                'method' => 'post',
                                'params' => [
                                    'work_id' => $model->id,
                                    'type' => 'create',
                                ],
                            ],
                            'data-pjax' => 1,
                            'style' => ''
                        ]
                    )
                    :
                    Html::a(
                        Html::img('../web/uploads/like-active.svg'),
                        ['', 'id' => $model->id],
                        [
                            'id' => 'like',
                            'class' => 'like button-text text-decoration-none',
                            'data' => [
                                'method' => 'post',
                                'params' => [
                                    'work_id' => $model->id,
                                    'type' => 'delete',
                                ],
                            ],
                            'data-pjax' => 1,
                            'style' => ''
                        ]
                    )
                ); ?>
                <?php Pjax::end() ?>
            </div>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProviderCategories,
            'itemOptions' => ['class' => ''],
            'summary' => '',
            'options' => [
                'class' => 'd-flex flex-row mb-3',
                'style' => 'gap:5px'
            ],
            'itemView' => function ($model) {

            return
                '<label class="checkbox-btn">' .
                "<input type='checkbox'" .
                'checked' . '>' .
                Html::tag('span', $model->title) .
                '</label>';
        }

        ]) ?>
        <?php if ($model->user_id == Yii::$app->user->id || Yii::$app->user->identity?->id): ?>
            <p>
                <?= Html::a('Обновить данные', ['update', 'id' => $model->id], ['class' => 'btn button-main-active']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn button-submain',
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить эту работу?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php endif ?>

        <div class="work-comments">
            <div class="header-label">Комментарии</div>
            <?php Pjax::begin(['id' => 'comment-objects', 'timeout' => false]) ?>
            <?= $this->render('_comment_form.php', ['modelComment' => $modelComment, 'model' => $model]) ?>

            <?= ListView::widget([
                'dataProvider' => $dataProviderComments,
                'itemOptions' => ['class' => 'work-item-comment'],
                'summary' => '',
                'itemView' => '_comment'

            ]) ?>
            <?php Pjax::end() ?>
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
            <div class="header-label mt-3">По тем же категориям</div>
            <div class="work-author-blocks">
                <?= ListView::widget([
                    'dataProvider' => $dataProviderLike,
                    'itemOptions' => ['class' => 'work-item-author'],
                    'summary' => '',
                    'itemView' => function ($model, $key, $index, $widget) {
                            return
                                Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]);
                        },
                ]) ?>
            </div>
        </div>
    </div>

</div>
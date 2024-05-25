<?php

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Like;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['id' => 'like' . '-' . $model->id])?>

<?= Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]) .
    '<div class="work-objects d-flex flex-row justify-content-between align-items-center">' .
    '<div class="d-flex flex-row" style="gap:15px">' .
    Html::a(Html::img('../web/uploads/' . User::findOne(['id' => $model->user_id])->img_url, ['class' => 'work-avatar']), ['/cabinet/author', 'id' => $model->user_id], ['data' => ['method' => 'post']])
    . '<div class="work-label d-flex align-items-center">' . $model->title . '</div>' . '</div>' .
    ((!Like::find()->where(['user_id' => Yii::$app->user->id, 'work_id' => $model->id])->exists()) ?

        Html::a(
            Html::img('../web/uploads/like.svg'),
            ['', 'id' => $model->user_id],
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
            ['', 'id' => $model->user_id],
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
    ) .
    '</div>';
?>
<?php Pjax::end()?>
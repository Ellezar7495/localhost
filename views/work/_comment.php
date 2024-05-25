<?
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="comment-card">
<div class="d-flex flex-row mb-3" style="gap:15px">
            <?= Html::a(Html::img('../web/uploads/' . User::findOne(['id' => $model->user_id])->img_url, ['class' => 'work-avatar']), ['/cabinet/author', 'id' => $model->user_id], ['data' => ['method' => 'post']]) ?>
            <div class="work-label d-flex align-items-center">
                <?= User::findOne(['id' => $model->user_id])->login ?>
            </div>
        </div>
    <div class="comment-card-body d-flex flex-row justify-content-between">

        <div class="d-flex align-items-center text-main">
            <?= Html::encode($model->content) ?>
        </div>

    </div>
</div>
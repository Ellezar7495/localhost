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
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Создать коллекцию', ['create'], ['class' => 'btn button-main-active']) ?>
</p>

<?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => [],
    'options' => [
        'class' => 'form-list'
    ],
    'summary' => '',
    'itemView' => function ($model, $key, $index, $widget) {
        return
            '<label class="checkbox-btn">' .
            '<input type="checkbox"' .
            'checked' . '>' .
            Html::tag('span', $model->title) .
            '</label>';
    },
]) ?>

<?php Pjax::end(); ?>
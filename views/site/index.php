<?php

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerCssFile('css/pic.css', ['depends' => [BootstrapAsset::class]]);
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>
 
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    
    <?= ListView::widget([
        'dataProvider' => $dataProviderWork,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget) {
                return
                    Html::a(Html::img('../web/uploads/' . $model->img_url, ['class' => 'work-item-img']), ['work/view', 'id' => $model->id]);
            },
    ]) ?>

    <?php Pjax::end(); ?>
</div>
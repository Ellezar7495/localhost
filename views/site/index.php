<?php

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Like;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerCssFile('css/pic.css', ['depends' => [BootstrapAsset::class]]);
// $this->registerJsFile('js/main.js', ['depends' => [JqueryAsset::class]]);
?>
<div class="site-index">
    <?php Pjax::begin(['id' => 'listview-objects', 'timeout' => false]); ?>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= ListView::widget([
        'dataProvider' => $dataProviderWork,
        'itemOptions' => ['class' => 'work-item'],
        'summary' => '',
        'itemView' => '_item'
    ]) ?>

    <?php Pjax::end(); ?>
</div>
<script>

</script>

    

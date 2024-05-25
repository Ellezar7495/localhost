<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = 'Обновление работы: ' . $model->title;
?>
<div class="work-update">

    <div class="header-label"><?= Html::encode($this->title) ?></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

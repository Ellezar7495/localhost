<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Collection $model */

$this->title = 'Create Collection';
?>
<div class="collection-create">

<h1 class="header-label">Создание коллекции</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

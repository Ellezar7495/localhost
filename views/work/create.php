<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = 'Create Work';

?>
<div class="work-create">

    <h1 class="header-label">Создание работы</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

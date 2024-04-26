<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Collection $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="collection-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-create']]); ?>

    <?= $form->field($model, 'title', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Заголовок'])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать коллекцию', ['class' => 'btn button-main-active']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

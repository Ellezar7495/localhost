<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-search">

<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'form-object-search',
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>

    <?= $form->field($model, 'search', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Поиск', 'autofocus' => true, 'onfocus' => "this.setSelectionRange(this.value.length,this.value.length);"])->label('') ?>

    <?php // echo $form->field($model, 'img_url') ?>

    <?php ActiveForm::end(); ?>

</div>

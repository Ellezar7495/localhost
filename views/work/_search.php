<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $model */
/** @var yii\widgets\ActiveForm $form */
// $this->registerJs('
//     /**
//      * Прикрепляет обновление контента после завершения работы виджета Pjax
//      */
//     $("#new-search-objects").on("pjax:end", function(ev) {
//         $.pjax.reload({container:"#gridview-objects"});
//     });

//     /**
//      * Отправки submit
//      */
//     function submitSearch() {
//         $("#form-object-search").submit();
//     }

//     /**
//      * Изменили любой список в форме
//      */
//     $(".object-search").on("change", "#form-object-search select", function() {
//         submitSearch();
//     });

//     /**
//      * Изменили любое текстовое поле в форме
//      */ 
//     $(".object-search").on("change", "#form-object-search input", function() {
//         submitSearch();
//     }); 
// ');
?>

<div class="work-search">
    
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 0
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'img_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
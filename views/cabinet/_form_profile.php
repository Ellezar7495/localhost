<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>




<div class="work-form">


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-create']]); ?>
    <?= Html::tag('span', 'Мои данные', ['class' => 'header-label']) ?>
    <?= Html::tag('span', 'E-mail: ' . Html::encode($model->email), ['class' => 'text-main'])?>
    <?= Html::tag('span', 'Пол: ' . Html::encode($model->sex), ['class' => 'text-main'])?>
    <?= $form->field($model, 'login', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Логин'])->label('') ?>
    <?= $form->field($model, 'imageFile', ['options' => ['class' => 'form-input']])->fileInput(['accept' => 'image/*', 'id' => 'imgInp'])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить изменения', ['class' => 'btn button-main-active']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php if ($model->img_url == null): ?>
        <div class="form-preview-border">
            <img id="blah" class="form-preview  invisible" src="#" alt="your image" />
        </div>
    <?php else: ?>
        <div class="form-preview-border">
            <img id="blah" class="form-preview" src="/web/uploads/<?= Html::encode($model->img_url) ?>" alt="your image" />
        </div>
    <?php endif ?>



    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.classList.remove('invisible')
                blah.src = URL.createObjectURL(file)
            } else {
                blah.src = '#'
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
</div>
<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="reg-background">


    <div class="site-reg">


        <div class="window"></div>
        <?php $form = ActiveForm::begin(['id' => 'reg-form','options' => ['enctype' => 'multipart/form-data', 'class' => 'reg-form']]); ?>
        <?= Html::tag('span', 'Регистрация', ['class' => 'header-label-black']) ?>
        <?= $form->field($model, 'login', ['options' => ['class' => 'form-input'], 'enableAjaxValidation' => true])->textInput(['placeholder' => 'Логин'])->label('') ?>
        <div class="form-reg">
            <?= $form->field($model, 'birthdate', ['options' => ['class' => 'form-input',]])->textInput(['type' => 'date'])->label('') ?>
            <?= $form->field($model, 'sex', ['options' => ['class' => 'form-input',]])->dropDownList([
                'Мужской' => 'Мужской',
                'Женский' => 'Женский',
                'Неопределён' => 'Неопределён',
            ], )->label('') ?>
        </div>

        <?= $form->field($model, 'email', ['options' => ['class' => 'form-input'], 'enableAjaxValidation' => true])->textInput(['placeholder' => 'e-mail'])->label('') ?>

        <?= $form->field($model, 'password', ['options' => ['class' => 'form-input',]])->passwordInput(['placeholder' => 'Пароль'])->label('') ?>
        <?= $form->field($model, 'password_repeat', ['options' => ['class' => 'form-input',]])->passwordInput(['placeholder' => 'Повтор пароля'])->label('') ?>



        <div class="form-group">
            <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn button-main-active']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div><!-- site-reg -->
</div>
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<div class="reg-background">
    <div class="site-reg">

        <div class="window"></div>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['enctype' => 'multipart/form-data', 'class' => 'reg-form']
        ]); ?>
        <?= Html::tag('span', 'Вход', ['class' => 'header-label-black']) ?>
        <?= $form->field($model, 'login', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Логин'])->label('') ?>

        <?= $form->field($model, 'password', ['options' => ['class' => 'form-input',]])->passwordInput(['placeholder' => 'Пароль'])->label('') ?>


        <div class="form-group">
            <?= Html::submitButton('Вход', ['class' => 'btn button-main-active']) ?>
            <li class="vr" style="background-color: #353531;"></li>
            <?= Html::a('Зарегестрироваться','reg', ['class' => 'btn button-main-black']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>
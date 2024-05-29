<?php

use app\models\Category;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Work $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="work-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-create']]); ?>

    <?= $form->field($model, 'title', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Заголовок'])->label('') ?>

    <?= $form->field($model, 'content', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Текст поста'])->label('') ?>
    <?= $form->field($model, 'categories_array', ['options' => ['class' => 'form-input-tags']])->checkboxList(
        Category::getCategories(),
        [
            'class' => 'form-list',
            'itemOptions' => [
                'class' => '',
            ],
            'item' =>
                function ($index, $label, $name, $checked, $value) use ($model) {
                        if ($model->categories_array == null) {
                            $res = '';
                        } else {
                            $res =
                                in_array(Category::findOne(['title' => $value])->title, $model->categories_array) ? 'checked' : '';
                        }
                        
                        return
                            '<label class="checkbox-btn">' .
                            "<input type='checkbox' name={$name} value={$value} " .
                            ($res) . '>' .
                            Html::tag('span', $value) .
                            '</label>';
                    }
        ],
    ) ?>

    <?= $form->field($model, 'imageFile', ['options' => ['class' => 'form-input']])->fileInput(['accept' => 'image/*', 'id' => 'imgInp']) ?>
    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn button-main-active'], ) ?>
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
            }
        }
    </script>

</div>
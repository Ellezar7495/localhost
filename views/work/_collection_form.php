<?php

use app\models\Category;
use app\models\Collection;
use app\models\Work;
use app\models\WorkCategory;
use app\models\WorkCollection;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$model;
?>
<?php Pjax::begin(['id' => 'addCollection']) ?>

<div class='dropdown'>
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">

    </button>
<?php $form = ActiveForm::begin(['options' => ['class' => 'd-flex flex-row', 'data-pjax' => true]]); ?>

    <?= $form->field(
        $modelCollection,
        'collections_array',
        [
            'options' =>
            ['class' => 'form-input-tags', 'tag' => 'ul', 'aria-labelledby' => 'dropdownMenuButton1']
        ]
    )->radioList(
        Collection::getCollections(),
        [
            'options' => [
                'multiple' => true
            ],
            'class' => 'dropdown-menu dropdown-menu-dark',

            'itemOptions' => [
                'class' => 'dropdown-item',

            ],
            'item' =>
            function ($index, $label, $name, $checked, $value) use ($model) {

                if (!WorkCollection::find()->where(['work_id' => Work::findOne(['id' => $model->id])->id, 'collection_id' => $value])->exists()) {
                    return
                        '<li>' .
                        '<label class="radio-btn m-auto">' .
                        "<input type='radio' name={$name} value={$value} checked" .
                        '>' .
                        Html::tag('span', $label, ['class' => 'ms-2']) .
                        Html::submitButton(Html::tag('span', '+', ['class' => 'nav-link p-0']), ['class' => 'button-text-margin text-decoration-none radio-visible'],) .
                        '</label>'
                        . '</li>';
                } else {
                    return
                    
                        '<li>' .
                        '<label class="radio-btn">' .
                        Html::tag('span', $label) .
                        Html::a(
                            ' x',
                            ['', 'id' => $model->id],
                            [
                                'id' => 'delete-collection',
                                'class' => 'like button-text-margin text-decoration-none',
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'collection_id' => WorkCollection::findOne(['work_id' => Work::findOne(['id' => $model->id])->id, 'collection_id' => $value])->id,
                                        'type' => 'delete-collection',
                                    ],
                                ],
                                'data-pjax' => 1,
                                'style' => ''
                            ]
                        )
                        . '</label>'
                        . '</li>';
                }
            }
        ],
    ) ?>


<?php ActiveForm::end(); ?>
</div>
<?php Pjax::end() ?>
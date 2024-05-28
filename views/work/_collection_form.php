<?
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
<? Pjax::begin(['id' => 'addCollection']) ?>


<?php $form = ActiveForm::begin(['options' => ['class' => 'd-flex flex-row', 'data-pjax' => true]]); ?>
<div class='dropdown'>
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">

    </button>
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
                    'tag' => 'li'
                ],
                'item' =>
                    function ($index, $label, $name, $checked, $value) use ($model) {

                            if (!WorkCollection::find()->where(['work_id' => Work::findOne(['id' => $model->id])->id, 'collection_id' => $value])->exists()) {
                                return
                                    '<label class="radio-btn">' .
                                    "<input type='radio' name={$name} value={$value} " .
                                    '>' .
                                    Html::tag('span', $label) .
                                    '</label>';
                            } else {
                                return Html::a(
                                    $label . ' x',
                                    ['', 'id' => $model->id],
                                    [
                                        'id' => 'delete-collection',
                                        'class' => 'like button-text text-decoration-none',
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
                                    );
                            }
                        }
            ],
        ) ?>
</div>
<?= Html::submitButton(Html::tag('span', '+', ['class' => 'nav-link']), ['class' => 'button-submain h-25'], ) ?>
<?php ActiveForm::end(); ?>
<? Pjax::end() ?>
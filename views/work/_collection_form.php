<?
use app\models\Category;
use app\models\Collection;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>
<? Pjax::begin(['id' => 'addCollection']) ?>


<?php $form = ActiveForm::begin(['options' => ['class' => 'd-flex flex-row', 'data-pjax' => true]]); ?>
<div class='dropdown'>
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
        aria-expanded="false">
        
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
                    function ($index, $label, $name, $checked, $value) use ($modelCollection) {
                            
                            return
                                '<label class="radio-btn">' .
                                "<input type='radio' name={$name} value={$value} " .
                                 '>' .
                                Html::tag('span', $label) .
                                '</label>';
                        }
            ],
        ) ?>
</div>
<?= Html::submitButton(Html::tag('span', '+', ['class' => 'nav-link']), ['class' => 'button-submain h-25'], ) ?>
<?php ActiveForm::end(); ?>
<? Pjax::end() ?>
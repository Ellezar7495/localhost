<?php

use app\models\Collection;
use app\models\User;
use app\models\Work;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\WorkSearch $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs('
    var timeout;
    $("#new-search-objects").on("pjax:end", function(ev) {
        $.pjax.reload("#listview-objects", {timeout : 0});
    });
    function submitSearch() {
        $("#form-object-search").submit();
    }
    $("#new-search-objects").on("input", "#form-object-search", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            submitSearch();
        }, 1000)
    }); 
');
?>
<?php Pjax::begin(['id' => 'new-search-objects', 'timeout' => 0]) ?>
<div class="work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['collections'],
        'method' => 'get',
        'id' => 'form-object-search',
        'options' => [
            'data-pjax' => true,
            'class' => 'd-flex align-items-center',
            'style' => 'gap:15px;'
        ],
    ]); ?>


    <?= $form->field($model, 'search', ['options' => ['class' => 'form-input']])->textInput(['placeholder' => 'Поиск', 'autofocus' => true, 'onfocus' => "this.setSelectionRange(this.value.length,this.value.length);"])->label('') ?>
    <li class="vr"></li>
    <?= $form->field($model, 'searchCollection', ['options' => ['class' => 'form-input']])->radioList(
        Collection::getCollections(),
        [
            'class' => 'form-list',
            'itemOptions' => [
                'class' => 'checkbox-btn',
            ],
            'item' =>
                function ($index, $label, $name, $checked, $value) use ($model) {
                    if ($model->searchCollection == null) {
                        $res = '';
                    } else {
                        $res = ($value == $model->searchCollection) ? 'checked' : '';
                    }
                    return
                        '<label class="checkbox-btn">' .
                        "<input type='radio' name={$name} value={$value} " .
                        ($res) . '>' .
                        Html::tag('span', $label) .
                        '</>';
                }
        ],
    )->label('') ?>
    <?= Html::a('+', ['/collection/create'], ['class' => 'button-submain nav-item text-decoration-none'])?>
    

<?= $form->field($model, 'searchAuthor', ['options' => ['class' => 'form-input']])->checkboxList(
        User::getAuthors(),
        [
            'class' => 'form-list',
            'itemOptions' => [
                'class' => 'checkbox-btn',
            ],
            'item' =>
                function ($index, $label, $name, $checked, $value) use ($model) {
                    if ($model->searchAuthor == null) {
                        $res = '';
                    } else {
                        $res = in_array($value, $model->searchAuthor) ? 'checked' : '';
                    }
                    return
                        '<label class="checkbox-btn">' .
                        "<input type='checkbox' name={$name} value={$value} " .
                        ($res) . '>' .
                        Html::tag('span', $label) . 
                        '</>';
                }
        ],
    )->label(''); ?>
    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end() ?>
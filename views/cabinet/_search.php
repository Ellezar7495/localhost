<?php

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
<?php Pjax::end() ?>
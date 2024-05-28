<?php

use app\models\Collection;
use app\models\User;
use app\models\Work;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
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
                'class' => '',
            ],
            'item' =>
                function ($index, $label, $name, $checked, $value) use ($model) {
                    if ($model->searchCollection == null) {
                        $res = '';
                        
                    } else {
                        $res = ($value == $model->searchCollection) ? 'checked' : '';
                    }
                    return
                        '<label class="radio-btn">' .

                        "<input type='radio' name={$name} value={$value} " .
                        ($res) . '>' .

                        (Html::tag(
                            'span',
                            $label .

                            Html::a(
                                'x',
                                ['/collection/delete', 'id' => $value],
                                [
                                    'class' => 'button-text text-decoration-none',
                                    'data' => [
                                        'method' => 'post'
                                    ],
                                    'style' => ''
                                ]
                            )
                            ,
                            ['class' => 'd-flex flex-row']
                        )
                        ) .
                        '</label>';
                }
        ],
    )->label('') ?>
    <?= Html::a('+', ['/collection/create'], ['class' => 'button-submain nav-item text-decoration-none']) ?>
    <?php
    // Modal::begin([
    //     'title' => '1',
    //     'toggleButton' => [
    //         'label' => 'click me',
    //         'tag' => 'button',
    //         'class' => 'btn btn-success',
    //     ],
    // ]);
    
    // echo 'Say hello...';
    
    // Modal::end();
    ?>

    
    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end() ?>
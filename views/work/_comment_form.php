<?
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>

<?= Html::beginForm(['', 'id' => $model->id], 'post', ['id' => 'comment', 'data-pjax' => 0, 'class' => 'd-flex flex-row justify-content-between my-3']); ?>
<div class="form-input field-work-content">
    <?= Html::input('text', 'content', '', ['class' => 'form-control', 'placeholder' => 'Комментарий']) ?>
</div>
<?= Html::submitButton('Ок', ['class' => 'btn button-main-active', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
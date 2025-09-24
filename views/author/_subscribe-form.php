<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SubscribeForm $formModel */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
Modal::begin([
    'options' => [
        'id' => 'subscribe-modal',
    ],
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
    'title' => '<h4>Оформить подписку на автора</h4>',
]);
?>

<div class="author-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['subscribe'],
        'id'     => 'subscribe-form',
    ]); ?>

    <?= $form->field($formModel, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
Modal::end();

$this->registerJs(<<<JS
$('#subscribe-modal').on('show.bs.modal', function (event) {
    var action = $(event.relatedTarget);
    $('#subscribe-form').attr('action', action.attr('href'));
});
JS
);

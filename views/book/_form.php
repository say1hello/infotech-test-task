<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookForm $formModel */
/** @var app\models\Author[] $authors */
/** @var \yii\bootstrap5\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($this->context->action->id == 'update'): ?>
        <?= Html::activeHiddenInput($formModel, 'id') ?>
    <?php endif; ?>

    <?= $form->field($formModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'pub_year')->textInput() ?>

    <?= $form->field($formModel, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($formModel, 'isbn')->textInput(['maxlength' => true]) ?>

    <?php if ($formModel->photo): ?>
        <?= Html::img(Yii::$app->urlManager->baseUrl . '/' . $formModel->photo, ['id' => 'bookform-photo', 'width' => 200, 'height' => 200, 'alt' => $formModel->photo]); ?>
    <?php endif; ?>

    <?= $form->field($formModel, 'imageFile')->fileInput() ?>

    <?= $form->field($formModel, 'authorsIds')->checkboxList(ArrayHelper::map($authors, 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BookForm $formModel */
/** @var app\models\Author[] $authors */

$this->title = 'Update Book: ' . $formModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->title, 'url' => ['view', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
        'authors' => $authors,
    ]) ?>

</div>

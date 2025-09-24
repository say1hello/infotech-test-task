<?php

use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'pub_year',
            'description:ntext',
            'isbn',
            [
                'attribute' => 'authors',
                'value' => function (Book $model) {
                    $links = [];
                    foreach ($model->authors as $author) {
                        $links[] = Html::a($author->name, ['author/view', 'id' => $author->id]);
                    }
                    return implode(', ', $links);
                },
                'format' => 'html',
            ],
//            'photo:image',
            [
                'attribute' => 'photo',
                'value' => function (Book $model) {
                    return Html::img(Yii::$app->urlManager->baseUrl . '/' . $model->photo, ['width' => 100, 'height' => 100, 'alt' => $model->photo]);
                },
                'format' => 'html',
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>

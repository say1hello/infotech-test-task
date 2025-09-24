<?php

use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'photo:image',
            [
                'attribute' => 'photo',
                'value' => function (Book $model) {
                    return Html::img(Yii::$app->urlManager->baseUrl . '/' . $model->photo, ['width' => 100, 'height' => 100, 'alt' => $model->photo]);
                },
                'format' => 'html',
            ],
            'title',
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
            'description:ntext',
            'isbn',
            'pub_year',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'update' => fn(Book $model, $key, $index) => !Yii::$app->user->isGuest,
                    'delete' => fn(Book $model, $key, $index) => !Yii::$app->user->isGuest,
                ],
            ],
        ],
    ]); ?>


</div>

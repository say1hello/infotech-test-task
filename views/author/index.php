<?php

use app\models\Author;
use app\models\SubscribeForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var SubscribeForm $subscribeFormModel */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'class' => ActionColumn::class,
                'header' => 'Действия',
                'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'template' => '{view} {update} {delete} {subscribe}',
                'buttons' => [
                    'subscribe' => static fn ($url, Author $model) => Html::a(
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
  <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
</svg>',
                        ['subscribe', 'id' => $model->id],
                        [
                            'data-bs-target' => '#subscribe-modal',
                            'data-bs-toggle' => 'modal',
                            'title' => 'Оформить подписку на автора',
                        ]
                    ),
                ],
                'visibleButtons' => [
                    'update' => fn(Author $model, $key, $index) => !Yii::$app->user->isGuest,
                    'delete' => fn(Author $model, $key, $index) => !Yii::$app->user->isGuest,
                    'subscribe' => fn(Author $model, $key, $index) => Yii::$app->user->isGuest,
                ],
            ],
        ],
    ]); ?>
</div>

<?= $this->render('_subscribe-form', ['formModel' => $subscribeFormModel]); ?>
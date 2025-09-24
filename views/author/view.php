<?php

use app\models\SubscribeForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Author $model */
/** @var SubscribeForm $subscribeFormModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(
                'Подписаться на обновления',
                ['subscribe', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data-bs-target' => '#subscribe-modal',
                    'data-bs-toggle' => 'modal',
                    'title' => 'Оформить подписку на автора',
                ]
        ); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>

<?= $this->render('_subscribe-form', ['formModel' => $subscribeFormModel]); ?>

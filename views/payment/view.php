<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'recipient.name',
                'label' => 'Получатель'
            ],
            [
                'attribute' => 'payer.name',
                'label' => 'Плательщик'
            ], 
            'amount',
            'created_at:datetime',
        ],
    ]) ?>

</div>

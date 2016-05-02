<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($model->isOwn() && $model->isEditable()) {?>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот счет?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php }?>

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
            [
                'label' => 'Статус',
                'value' => $model->getStatusName()
            ],
            'payment_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>

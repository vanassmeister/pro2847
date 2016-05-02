<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;

$view = $this;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => 'Получатель',
                'attribute' => 'recipient.name',
            ],
            [
                'label' => 'Плательщик',
                'attribute' => 'payer.name',
            ],
            [
                'attribute' => 'amount',
                'content' => function($row) use ($view){
                    /* @var $row app\models\Order */
                    $buttons = '';
                    if(!$row->isOwn() && $row->status == Order::STATUS_NEW) {
                        $buttons = $view->render('_buttons', ['model' => $row]);
                    }
                    
                    return $row->amount.$buttons;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($row) {
                    return $row->getStatusName();
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' => function ($model) {
                        return $model->isOwn() && $model->isEditable();
                    },
                    'delete' => function ($model) {
                        return $model->isOwn() && $model->isEditable();
                    },                        
                ],                
            ],
        ],
    ]); ?>
</div>

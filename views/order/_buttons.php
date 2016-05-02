<?php
/* 
 * @author Ivan Nikiforov
 * May 2, 2016
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model app\models\Order */
echo ' ';
$payForm = ActiveForm::begin([
    'action' => Url::toRoute(['order/pay', 'id' => $model->id]), 
    'method' => 'post',
    'options' => ['class' => 'order-form']
    
]);
echo Html::submitButton('Оплатить', ['class' => 'btn btn-success btn-xs']);
$payForm->end();
echo ' ';
$declineForm = ActiveForm::begin([
    'action' => Url::toRoute(['order/decline', 'id' => $model->id]), 
    'method' => 'post',
    'options' => ['class' => 'order-form']
]);
echo Html::submitButton('Отклонить', ['class' => 'btn btn-danger btn-xs']);
$declineForm->end();

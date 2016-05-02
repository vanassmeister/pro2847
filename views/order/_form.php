<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\FormHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payer_id')->widget(Select2::classname(), [
        'data' => FormHelper::getUserOptions(),
        'language' => 'ru',
        'options' => ['placeholder' => Yii::t('app', 'Выберите плательщика...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

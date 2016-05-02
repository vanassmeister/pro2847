<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=GridView::widget([
        'dataProvider' => $usersProvider,
        'columns' => [
            'name',
            'balance'
        ],
    ])?>    
</div>

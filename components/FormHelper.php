<?php

namespace app\components;

use yii\helpers\ArrayHelper;
use app\models\User;
use Yii;

/*
 * @author Ivan Nikiforov
 * May 2, 2016
 */

/**
 * Description of FormHelper
 *
 * @author ivan
 */
class FormHelper
{
    public static function getUserOptions() {
        return ArrayHelper::map(User::find()->orderBy('name')
        ->where(['<>','id', Yii::$app->user->id])->all(), 'id', 'name');
    }
}

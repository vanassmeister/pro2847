<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_'.uniqid(),

        ]);

        // Пользователь должен создаваться и логиниться
        $this->specify('user should be able to login, when there is no identity', function () use ($model) {
            expect('model should login user', $model->login())->true();
            expect('user should be logged in', Yii::$app->user->isGuest)->false();
        });
    }

}

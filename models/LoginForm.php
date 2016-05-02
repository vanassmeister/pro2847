<?php namespace app\models;

use Yii;
use yii\base\Model;
use Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $username;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user) {
            return $this->_user;
        }
            
        $this->_user = User::findByUsername($this->username);
        if($this->_user) {
            return $this->_user;
        }
        
        $user = new User();
        $user->name = $this->username;

        if(!$user->save()) {
            throw new Exception("Невозможно сохранить пользователя {$user->name}");
        }
        
        $this->_user = $user;
        return $this->_user;
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'rememberMe' => 'Запомнить меня'
        ];
    }
}

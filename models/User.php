<?php namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property integer $balance
 *
 * @property Order[] $ordersPayer
 * @property Order[] $ordersRecipient
 * @property Payment[] $paymentsPayer
 * @property Payment[] $paymentsRecipient
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['balance'], 'number'],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя пользователя',
            'balance' => 'Баланс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPayer()
    {
        return $this->hasMany(Order::className(), ['payer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersRecipient()
    {
        return $this->hasMany(Order::className(), ['recipient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentsPayer()
    {
        return $this->hasMany(Payment::className(), ['payer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentsRecipient()
    {
        return $this->hasMany(Payment::className(), ['recipient_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->name;
    }

    public function validateAuthKey($authKey)
    {
        return $this->name === $authKey;
    }

    public static function findByUsername($name)
    {
        return static::findOne(['name' => $name]);
    }
}

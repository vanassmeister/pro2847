<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $recipient_id
 * @property integer $payer_id
 * @property string $amount
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order[] $orders
 * @property User $payer
 * @property User $recipient
 */
class Payment extends \yii\db\ActiveRecord
{
    
    public $recipientName;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }     

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipientName', 'amount'], 'required'],
            [['recipientName'], 'string', 'max' => 32],            
            [['recipient_id', 'payer_id'], 'integer'],
            [['amount'], 'number'],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipientName' => 'Получатель',
            'payer_id' => 'Payer ID',
            'amount' => 'Сумма',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['payment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayer()
    {
        return $this->hasOne(User::className(), ['id' => 'payer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}

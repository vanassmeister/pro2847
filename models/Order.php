<?php namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $recipient_id
 * @property integer $payer_id
 * @property string $amount
 * @property integer $status
 * @property integer $payment_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $payer
 * @property Payment $payment
 * @property User $recipient
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_PAYED = 1;
    const STATUS_DECLINED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
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
            [['payer_id', 'amount'], 'required'],
            [['payer_id', 'status', 'payment_id'], 'integer'],
            [['amount'], 'number'],
            [['payer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['payer_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['payment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient_id' => 'Получатель',
            'payer_id' => 'Плательщик',
            'amount' => 'Сумма',
            'status' => 'Статус',
            'payment_id' => 'ID платежа',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
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
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    public static function getStatusNames()
    {
        return [
            self::STATUS_NEW => 'Создан',
            self::STATUS_PAYED => 'Оплачен',
            self::STATUS_DECLINED => 'Отклонен',
        ];
    }

    public function getStatusName()
    {
        $names = self::getStatusNames();
        return isset($names[$this->status]) ? $names[$this->status] : '';
    }

    public function isOwn()
    {
        return $this->recipient_id == Yii::$app->user->id;
    }
    
    public function isEditable()
    {
        return $this->status == self::STATUS_NEW;
    }    
}

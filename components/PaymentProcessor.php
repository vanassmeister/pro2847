<?php
/*
 * @author Ivan Nikiforov
 * May 2, 2016
 */
namespace app\components;

use app\models\Payment;
use app\models\Order;
use app\models\User;
use Exception;
use Yii;

/**
 * Description of PaymentProcessor
 *
 * @author ivan
 */
class PaymentProcessor
{

    /**
     * Проводка платежа
     * @param Payment $payment
     * @return boolean
     * @throws Exception
     */
    public static function processPayment(Payment $payment)
    {
        $payer = Yii::$app->user->identity;
        $payment->payer_id = $payer->id;

        if($payment->recipient_id) {
            $recipient = User::findOne($payment->recipient_id);
        } else {
            $recipient = User::findOne(['name' => $payment->recipientName]);
        }
        
        if(!$recipient) {
            $recipient = new User();
            $recipient->name = $payment->recipientName;
            if (!$recipient->save()) {
                throw new Exception('Невозможно сохранить получателя');
            }
        }
        
        $payment->recipient_id = $recipient->id;

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if (!$payment->save()) {
                throw new Exception('Невозможно сохранить платеж '.  var_export($payment->getErrors(), true));
            }

            $payer->balance -= $payment->amount;
            $recipient->balance += $payment->amount;

            if (!$payer->save(true, ['balance'])) {
                throw new Exception('Невозможно сохранить баланс плательщика');
            }

            if (!$recipient->save(true, ['balance'])) {
                throw new Exception('Невозможно сохранить баланс получателя');
            }

            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * Оплата ордера
     * @param Order $order
     * @throws Exception
     */
    public static function payOrder(Order $order)
    {
        $payment = new Payment();
        $payment->recipient_id = $order->recipient_id;
        $payment->amount = $order->amount;

        if (self::processPayment($payment)) {
            $order->status = Order::STATUS_PAYED;
            $order->payment_id = $payment->id;
            
            if (!$order->save(true, ['payment_id','status'])) {
                throw new Exception('Невозможно сохранить параметры ордера');
            }
        }
    }

    /**
     * Отклонение ордера
     * @param Order $order
     * @throws Exception
     */
    public static function declineOrder(Order $order)
    {
        $order->status = Order::STATUS_DECLINED;
        if (!$order->save(true, ['status'])) {
            throw new Exception('Невозможно сохранить статус ордера');
        }        
    }
}

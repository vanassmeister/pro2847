<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160502_080648_create_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        // Пользователи
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull()->unique(),
            'balance' => $this->integer()->defaultValue(0)
        ]);
        
        // Счета
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'recipient_id' => $this->integer()->notNull(),
            'payer_id' => $this->integer()->notNull(),
            'amount' => $this->money()->notNull(),
            'status' => $this->integer()->defaultValue(0)->notNull(),
            'payment_id' => $this->integer(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
        
        // Платежи
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'recipient_id' => $this->integer()->notNull(),
            'payer_id' => $this->integer()->notNull(),
            'amount' => $this->money()->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
        
        $this->addForeignKey('fk_order_recipient_id', 'order', ['recipient_id'], 'user', ['id']);
        $this->addForeignKey('fk_order_payer_id', 'order', ['payer_id'], 'user', ['id']);
        $this->addForeignKey('fk_order_payment_id', 'order', ['payment_id'], 'payment', ['id']);
        
        $this->addForeignKey('fk_payment_recipient_id', 'payment', ['recipient_id'], 'user', ['id']);
        $this->addForeignKey('fk_payment_payer_id', 'payment', ['payer_id'], 'user', ['id']);

        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}

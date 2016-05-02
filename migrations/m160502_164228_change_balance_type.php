<?php

use yii\db\Migration;

class m160502_164228_change_balance_type extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE user MODIFY balance decimal(19,4)');
    }

    public function down()
    {
        echo "m160502_164228_change_balance_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

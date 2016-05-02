<?php

use yii\db\Migration;

class m160502_194308_change_balance_properties extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE user ALTER COLUMN balance SET DEFAULT 0');
    }

    public function down()
    {
        echo "m160502_194308_change_balance_properties cannot be reverted.\n";

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

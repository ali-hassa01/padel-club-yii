<?php

use yii\db\Migration;

class m260913_120953_create_loyalty_table extends Migration
{
    public function safeUp()
    {
        // Har player ke har mahine ke hours track karne ke liye
        $this->createTable('{{%loyalty_log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'year_month' => $this->string(7)->notNull(), // format: '2026-09'
            'hours_played' => $this->decimal(5, 2)->notNull()->defaultValue(0),
            'reward_type' => $this->string(20)->null(), // discount_20 / free_slot / null
            'reward_used' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-loyaltylog-user', '{{%loyalty_log}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Ek player ka ek hi record ho har month ke liye
        $this->createIndex('idx-loyaltylog-user-month', '{{%loyalty_log}}', ['user_id', 'year_month'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx-loyaltylog-user-month', '{{%loyalty_log}}');
        $this->dropForeignKey('fk-loyaltylog-user', '{{%loyalty_log}}');
        $this->dropTable('{{%loyalty_log}}');
    }
}
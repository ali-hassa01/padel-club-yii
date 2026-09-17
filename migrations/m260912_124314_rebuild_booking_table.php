<?php

use yii\db\Migration;

class m260912_124314_rebuild_booking_table extends Migration
{
    public function safeUp()
    {
        // Pehle purani (incomplete) table hatayein
        $this->dropTable('{{%booking}}');

        // Ab sahi, poori table dobara banayein
        $this->createTable('{{%booking}}', [
            'id' => $this->primaryKey(),
            'court_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'guest_name' => $this->string(150)->null(),
            'guest_email' => $this->string(255)->null(),
            'guest_phone' => $this->string(20)->null(),
            'booking_date' => $this->date()->notNull(),
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'game_type' => $this->string(50)->null(),
            'payment_status' => $this->string(20)->notNull()->defaultValue('pending'),
            'payment_amount' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'loyalty_hours_counted' => $this->boolean()->notNull()->defaultValue(0),
            'status' => $this->string(20)->notNull()->defaultValue('confirmed'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-booking-court_id',
            '{{%booking}}',
            'court_id',
            '{{%court}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-booking-user_id',
            '{{%booking}}',
            'user_id',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-booking-court_id', '{{%booking}}');
        $this->dropForeignKey('fk-booking-user_id', '{{%booking}}');
        $this->dropTable('{{%booking}}');
    }
}
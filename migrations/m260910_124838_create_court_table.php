<?php

use yii\db\Migration;

class m260910_124838_create_court_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%court}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'type' => $this->string(20)->notNull()->defaultValue('indoor'), // indoor / outdoor
            'surface_type' => $this->string(50)->null(),
            'has_lighting' => $this->boolean()->notNull()->defaultValue(0),
            'price_per_slot' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'image' => $this->string(255)->null(),
            'description' => $this->text()->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1), // 1 = active, 0 = inactive
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%court}}');
    }
}
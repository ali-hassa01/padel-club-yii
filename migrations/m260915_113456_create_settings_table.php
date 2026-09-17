<?php

use yii\db\Migration;

class m260915_113456_create_settings_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'setting_key' => $this->string(100)->notNull()->unique(),
            'setting_value' => $this->string(255)->notNull(),
            'description' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Default values - boss ki documentation ke mutabiq
        $now = time();
        $this->batchInsert('{{%settings}}', ['setting_key', 'setting_value', 'description', 'created_at', 'updated_at'], [
            ['loyalty_discount_min_hours', '12', 'Minimum hours in a month for 20% discount reward', $now, $now],
            ['loyalty_discount_max_hours', '14', 'Maximum hours in a month for 20% discount reward', $now, $now],
            ['loyalty_free_slot_min_hours', '15', 'Minimum hours in a month for a free slot reward', $now, $now],
            ['loyalty_discount_percent', '20', 'Discount percentage applied when redeeming a discount reward', $now, $now],
            ['ladder_tier_diamond_min', '2000', 'Minimum points for Diamond tier', $now, $now],
            ['ladder_tier_platinum_min', '1500', 'Minimum points for Platinum tier', $now, $now],
            ['ladder_tier_gold_min', '1000', 'Minimum points for Gold tier', $now, $now],
            ['ladder_tier_silver_min', '500', 'Minimum points for Silver tier', $now, $now],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
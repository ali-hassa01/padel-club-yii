<?php

use yii\db\Migration;

class m260912_161114_create_match_table extends Migration
{
    public function safeUp()
    {
        // Open matches (matchmaking module)
        $this->createTable('{{%match}}', [
            'id' => $this->primaryKey(),
            'booking_id' => $this->integer()->null(),
            'created_by' => $this->integer()->notNull(),
            'match_date' => $this->date()->notNull(),
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'court_id' => $this->integer()->null(),
            'skill_level' => $this->string(20)->null(),
            'slots_needed' => $this->integer()->notNull()->defaultValue(3),
            'status' => $this->string(20)->notNull()->defaultValue('open'), // open / full / completed / cancelled
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Match ke participants (kaun kaun join hua)
        $this->createTable('{{%match_player}}', [
            'id' => $this->primaryKey(),
            'match_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'joined_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-match-court_id', '{{%match}}', 'court_id', '{{%court}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-match-created_by', '{{%match}}', 'created_by', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-match-booking_id', '{{%match}}', 'booking_id', '{{%booking}}', 'id', 'SET NULL');

        $this->addForeignKey('fk-matchplayer-match_id', '{{%match_player}}', 'match_id', '{{%match}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-matchplayer-user_id', '{{%match_player}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-matchplayer-user_id', '{{%match_player}}');
        $this->dropForeignKey('fk-matchplayer-match_id', '{{%match_player}}');
        $this->dropTable('{{%match_player}}');

        $this->dropForeignKey('fk-match-booking_id', '{{%match}}');
        $this->dropForeignKey('fk-match-created_by', '{{%match}}');
        $this->dropForeignKey('fk-match-court_id', '{{%match}}');
        $this->dropTable('{{%match}}');
    }
}
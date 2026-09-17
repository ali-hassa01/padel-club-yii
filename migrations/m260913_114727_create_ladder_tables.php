<?php

use yii\db\Migration;

class m260913_114727_create_ladder_tables extends Migration
{
    public function safeUp()
    {
        // Team = 2 registered players
        $this->createTable('{{%team}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'player1_id' => $this->integer()->notNull(),
            'player2_id' => $this->integer()->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('active'), // active / temp_frozen
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Ladder entry = ek team ki ranking, ek specific ladder (beginner/intermediate) mein
        $this->createTable('{{%ladder_entry}}', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer()->notNull(),
            'ladder_type' => $this->string(20)->notNull(), // beginner / intermediate
            'tier' => $this->string(20)->notNull()->defaultValue('bronze'), // diamond/platinum/gold/silver/bronze
            'rank_position' => $this->integer()->notNull()->defaultValue(0),
            'points' => $this->integer()->notNull()->defaultValue(0),
            'wins' => $this->integer()->notNull()->defaultValue(0),
            'losses' => $this->integer()->notNull()->defaultValue(0),
            'streak' => $this->integer()->notNull()->defaultValue(0),
            'last_active_at' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-team-player1', '{{%team}}', 'player1_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-team-player2', '{{%team}}', 'player2_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-ladderentry-team', '{{%ladder_entry}}', 'team_id', '{{%team}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-ladderentry-team', '{{%ladder_entry}}');
        $this->dropForeignKey('fk-team-player1', '{{%team}}');
        $this->dropForeignKey('fk-team-player2', '{{%team}}');
        $this->dropTable('{{%ladder_entry}}');
        $this->dropTable('{{%team}}');
    }
}
<?php

use yii\db\Migration;

class m260910_115407_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'phone' => $this->string(20)->null(),
            'skill_level' => $this->string(20)->null(),
            'role' => $this->string(20)->notNull()->defaultValue('player'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'verification_token' => $this->string()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
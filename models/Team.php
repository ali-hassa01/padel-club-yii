<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Team extends ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_TEMP_FROZEN = 'temp_frozen';

    public static function tableName()
    {
        return '{{%team}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['name', 'player1_id', 'player2_id'], 'required'],
            [['player1_id', 'player2_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['player2_id'], 'compare', 'compareAttribute' => 'player1_id', 'operator' => '!=', 'message' => 'The two players must be different.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Team Name',
            'player1_id' => 'Player 1',
            'player2_id' => 'Player 2',
            'status' => 'Status',
        ];
    }

    public function getPlayer1()
    {
        return $this->hasOne(User::class, ['id' => 'player1_id']);
    }

    public function getPlayer2()
    {
        return $this->hasOne(User::class, ['id' => 'player2_id']);
    }

    public function getLadderEntries()
    {
        return $this->hasMany(LadderEntry::class, ['team_id' => 'id']);
    }
}
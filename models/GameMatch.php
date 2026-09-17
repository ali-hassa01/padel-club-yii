<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class GameMatch extends ActiveRecord
{
    const STATUS_OPEN = 'open';
    const STATUS_FULL = 'full';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public static function tableName()
    {
        return '{{%match}}';
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
            [['match_date', 'start_time', 'end_time'], 'required'],
            [['court_id', 'created_by', 'slots_needed'], 'integer'],
            [['match_date'], 'date', 'format' => 'php:Y-m-d'],
            [['skill_level'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => self::STATUS_OPEN],
            [['slots_needed'], 'default', 'value' => 3],
        ];
    }

    public function attributeLabels()
    {
        return [
            'match_date' => 'Match Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'court_id' => 'Court',
            'skill_level' => 'Skill Level',
            'slots_needed' => 'Players Needed',
            'status' => 'Status',
        ];
    }

    public function getCourt()
    {
        return $this->hasOne(Court::class, ['id' => 'court_id']);
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getPlayers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%match_player}}', ['match_id' => 'id']);
    }

    public function getJoinedCount()
    {
        return MatchPlayer::find()->where(['match_id' => $this->id])->count();
    }

    public function isFull()
    {
        return $this->getJoinedCount() >= $this->slots_needed;
    }
}
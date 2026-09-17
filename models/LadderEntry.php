<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\models\Setting;

class LadderEntry extends ActiveRecord
{
    const LADDER_BEGINNER = 'beginner';
    const LADDER_INTERMEDIATE = 'intermediate';

    const TIER_DIAMOND = 'diamond';
    const TIER_PLATINUM = 'platinum';
    const TIER_GOLD = 'gold';
    const TIER_SILVER = 'silver';
    const TIER_BRONZE = 'bronze';

    public static function tableName()
    {
        return '{{%ladder_entry}}';
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
            [['team_id', 'ladder_type'], 'required'],
            [['team_id', 'rank_position', 'points', 'wins', 'losses', 'streak'], 'integer'],
            [['ladder_type', 'tier'], 'string', 'max' => 20],
            [['tier'], 'default', 'value' => self::TIER_BRONZE],
        ];
    }

    public function attributeLabels()
    {
        return [
            'team_id' => 'Team',
            'ladder_type' => 'Ladder',
            'tier' => 'Tier',
            'rank_position' => 'Rank',
            'points' => 'Points',
            'wins' => 'Wins',
            'losses' => 'Losses',
            'streak' => 'Streak',
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }

    // Team ne match jeeta
    public function recordWin()
    {
        $this->wins += 1;
        $this->points += 3;
        $this->streak = $this->streak >= 0 ? $this->streak + 1 : 1;
        $this->last_active_at = time();
        $this->updateTier();
        $this->save();
    }

        public function updateTier()
    {
        $diamond = (float) Setting::get('ladder_tier_diamond_min', 2000);
        $platinum = (float) Setting::get('ladder_tier_platinum_min', 1500);
        $gold = (float) Setting::get('ladder_tier_gold_min', 1000);
        $silver = (float) Setting::get('ladder_tier_silver_min', 500);

        if ($this->points >= $diamond) {
            $this->tier = self::TIER_DIAMOND;
        } elseif ($this->points >= $platinum) {
            $this->tier = self::TIER_PLATINUM;
        } elseif ($this->points >= $gold) {
            $this->tier = self::TIER_GOLD;
        } elseif ($this->points >= $silver) {
            $this->tier = self::TIER_SILVER;
        } else {
            $this->tier = self::TIER_BRONZE;
        }
    }

    // Team match haar gayi
    public function recordLoss()
    {
        $this->losses += 1;
        $this->streak = $this->streak <= 0 ? $this->streak - 1 : -1;
        $this->last_active_at = time();
        $this->save();
    }
}
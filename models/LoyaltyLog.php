<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Setting;
use yii\behaviors\TimestampBehavior;

class LoyaltyLog extends ActiveRecord
{
    const REWARD_DISCOUNT = 'discount_20';
    const REWARD_FREE_SLOT = 'free_slot';

    const THRESHOLD_DISCOUNT_MIN = 12;
    const THRESHOLD_FREE_SLOT_MIN = 15;

    public static function tableName()
    {
        return '{{%loyalty_log}}';
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
            [['user_id', 'year_month'], 'required'],
            [['user_id'], 'integer'],
            [['hours_played'], 'number'],
            [['year_month'], 'string', 'max' => 7],
            [['reward_type'], 'string', 'max' => 20],
            [['reward_used'], 'boolean'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Har booking ke baad ye call hoga taake current month ke hours update hon
     */
    public static function addHours($userId, $hours)
    {
        $yearMonth = date('Y-m');

        $log = self::findOne(['user_id' => $userId, 'year_month' => $yearMonth]);

        if (!$log) {
            $log = new self();
            $log->user_id = $userId;
            $log->year_month = $yearMonth;
            $log->hours_played = 0;
        }

        $log->hours_played += $hours;

                // Reward calculate karna — ab Settings table se values liye jaate hain (admin-configurable)
        $freeSlotMin = (float) Setting::get('loyalty_free_slot_min_hours', self::THRESHOLD_FREE_SLOT_MIN);
        $discountMin = (float) Setting::get('loyalty_discount_min_hours', self::THRESHOLD_DISCOUNT_MIN);

        if ($log->hours_played >= $freeSlotMin) {
            $log->reward_type = self::REWARD_FREE_SLOT;
        } elseif ($log->hours_played >= $discountMin) {
            $log->reward_type = self::REWARD_DISCOUNT;
        }

        $log->save();

        return $log;
    }

    /**
     * Player ka currently available (unused) reward dhoondhna - kisi bhi mahine ka ho sakta hai
     */
    public static function getAvailableReward($userId)
    {
        return self::find()
            ->where(['user_id' => $userId, 'reward_used' => false])
            ->andWhere(['not', ['reward_type' => null]])
            ->orderBy(['year_month' => SORT_DESC])
            ->one();
    }
}

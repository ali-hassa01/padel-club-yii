<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property int $court_id
 * @property int|null $user_id
 * @property string|null $guest_name
 * @property string|null $guest_email
 * @property string|null $guest_phone
 * @property string $booking_date
 * @property string $start_time
 * @property string $end_time
 * @property string|null $game_type
 * @property string $payment_status
 * @property float $payment_amount
 * @property int $loyalty_hours_counted
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 */
class Booking extends ActiveRecord
{
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';

    public static function tableName()
    {
        return '{{%booking}}';
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
            [['court_id', 'booking_date', 'start_time', 'end_time'], 'required'],
            [['court_id', 'user_id', 'loyalty_hours_counted'], 'integer'],
            [['booking_date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_time', 'end_time'], 'string'],
            [['payment_amount'], 'number'],
            [['guest_name'], 'string', 'max' => 150],
            [['guest_email'], 'string', 'max' => 255],
            [['guest_phone', 'game_type'], 'string', 'max' => 50],
            [['payment_status'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 20],
            [['payment_status'], 'default', 'value' => self::PAYMENT_PENDING],
            [['status'], 'default', 'value' => self::STATUS_CONFIRMED],
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'court_id' => 'Court',
            'user_id' => 'Player',
            'guest_name' => 'Guest Name',
            'guest_email' => 'Guest Email',
            'guest_phone' => 'Guest Phone',
            'booking_date' => 'Booking Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'game_type' => 'Game Type',
            'payment_status' => 'Payment Status',
            'payment_amount' => 'Payment Amount',
            'loyalty_hours_counted' => 'Loyalty Hours Counted',
            'status' => 'Status',
        ];
    }

    public function getCourt()
    {
        return $this->hasOne(Court::class, ['id' => 'court_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
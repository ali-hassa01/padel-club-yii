<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Court;
use app\models\Booking;
use app\models\LoyaltyLog;

class BookController extends Controller
{
    public function actionIndex()
    {
        $courts = Court::find()->where(['status' => Court::STATUS_ACTIVE])->all();

        $courtId = Yii::$app->request->get('court_id');
        $date = Yii::$app->request->get('date');

        $slots = [];
        $selectedCourt = null;

        if ($courtId && $date) {
            $selectedCourt = Court::findOne($courtId);

            if ($selectedCourt) {
                $existingBookings = Booking::find()
                    ->where([
                        'court_id' => $courtId,
                        'booking_date' => $date,
                        'status' => Booking::STATUS_CONFIRMED,
                    ])
                    ->all();

                $bookedTimes = [];
                foreach ($existingBookings as $b) {
                    $bookedTimes[] = $b->start_time;
                }

                // 8 AM to 10 PM, 1-hour slots
                for ($hour = 8; $hour < 22; $hour++) {
                    $start = sprintf('%02d:00:00', $hour);
                    $end = sprintf('%02d:00:00', $hour + 1);

                    $slots[] = [
                        'start' => $start,
                        'end' => $end,
                        'label' => sprintf('%02d:00 - %02d:00', $hour, $hour + 1),
                        'available' => !in_array($start, $bookedTimes),
                    ];
                }
            }
        }

        $availableReward = null;
        if (!Yii::$app->user->isGuest) {
            $availableReward = LoyaltyLog::getAvailableReward(Yii::$app->user->id);
        }

        return $this->render('index', [
            'courts' => $courts,
            'courtId' => $courtId,
            'date' => $date,
            'slots' => $slots,
            'selectedCourt' => $selectedCourt,
            'availableReward' => $availableReward,
        ]);
    }

    public function actionConfirm()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return $this->redirect(['index']);
        }

        $model = new Booking();
        $model->court_id = $request->post('court_id');
        $model->booking_date = $request->post('booking_date');
        $model->start_time = $request->post('start_time');
        $model->end_time = $request->post('end_time');
        $model->game_type = $request->post('game_type');
        $model->payment_status = Booking::PAYMENT_PENDING;
        $model->status = Booking::STATUS_CONFIRMED;

        $court = Court::findOne($model->court_id);
        $model->payment_amount = $court ? $court->price_per_slot : 0;

        $useReward = $request->post('use_reward');
        $rewardToMark = null;

        if ($useReward && !Yii::$app->user->isGuest) {
            $reward = LoyaltyLog::getAvailableReward(Yii::$app->user->id);
            if ($reward) {
                if ($reward->reward_type === 'free_slot') {
                    $model->payment_amount = 0;
                                } elseif ($reward->reward_type === 'discount_20') {
                    $discountPercent = (float) \app\models\Setting::get('loyalty_discount_percent', 20);
                    $model->payment_amount = $model->payment_amount * (1 - $discountPercent / 100);
                }
                $rewardToMark = $reward;
            }
        }

        if (!Yii::$app->user->isGuest) {
            $model->user_id = Yii::$app->user->id;
        } else {
            $model->guest_name = $request->post('guest_name');
            $model->guest_email = $request->post('guest_email');
            $model->guest_phone = $request->post('guest_phone');
        }

        // Double check - make sure no one else booked this slot at the same time
        $clash = Booking::find()->where([
            'court_id' => $model->court_id,
            'booking_date' => $model->booking_date,
            'start_time' => $model->start_time,
            'status' => Booking::STATUS_CONFIRMED,
        ])->exists();

        if ($clash) {
            Yii::$app->getSession()->setFlash('error', 'This slot was just booked by someone else. Please select another slot.');
            return $this->redirect(['index', 'court_id' => $model->court_id, 'date' => $model->booking_date]);
        }

        if ($model->save()) {
            if ($rewardToMark) {
                $rewardToMark->reward_used = true;
                $rewardToMark->save();
            }

            // Only add loyalty hours for registered players (guests are exempt)
            if ($model->user_id) {
                $startParts = explode(':', $model->start_time);
                $endParts = explode(':', $model->end_time);
                $hours = ($endParts[0] - $startParts[0]) + (($endParts[1] - $startParts[1]) / 60);

                LoyaltyLog::addHours($model->user_id, $hours);

                $model->loyalty_hours_counted = 1;
                $model->save(false);
            }

            Yii::$app->getSession()->setFlash('success', 'Booking confirmed! Court: ' . ($court ? $court->name : '') . ', Date: ' . $model->booking_date . ', Time: ' . substr($model->start_time, 0, 5) . ' - ' . substr($model->end_time, 0, 5));
            return $this->redirect(['index']);
        }

        Yii::$app->getSession()->setFlash('error', 'Booking could not be saved: ' . implode(', ', $model->getErrorSummary(true)));
        return $this->redirect(['index', 'court_id' => $model->court_id, 'date' => $model->booking_date]);
    }
}
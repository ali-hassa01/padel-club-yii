<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\LoyaltyLog;

class LoyaltyController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // sirf logged-in players
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $currentMonth = date('Y-m');

        $currentLog = LoyaltyLog::findOne(['user_id' => $userId, 'year_month' => $currentMonth]);
        $availableReward = LoyaltyLog::getAvailableReward($userId);

        $history = LoyaltyLog::find()
            ->where(['user_id' => $userId])
            ->orderBy(['year_month' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'currentLog' => $currentLog,
            'availableReward' => $availableReward,
            'history' => $history,
        ]);
    }
}
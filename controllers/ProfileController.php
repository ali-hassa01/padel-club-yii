<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Booking;
use app\models\GameMatch;
use app\models\LoyaltyLog;
use app\models\Team;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // sirf logged-in users
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $upcomingBookings = Booking::find()
            ->where(['user_id' => $userId])
            ->andWhere(['>=', 'booking_date', date('Y-m-d')])
            ->orderBy(['booking_date' => SORT_ASC])
            ->all();

        $myMatches = GameMatch::find()
            ->joinWith('players')
            ->where(['{{%match_player}}.user_id' => $userId])
            ->all();

        $myTeams = Team::find()
            ->where(['player1_id' => $userId])
            ->orWhere(['player2_id' => $userId])
            ->all();

        $currentLoyalty = LoyaltyLog::findOne(['user_id' => $userId, 'year_month' => date('Y-m')]);

        return $this->render('index', [
            'upcomingBookings' => $upcomingBookings,
            'myMatches' => $myMatches,
            'myTeams' => $myTeams,
            'currentLoyalty' => $currentLoyalty,
        ]);
    }

    public function actionEdit()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Profile updated successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }
}
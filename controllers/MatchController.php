<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\GameMatch;
use app\models\MatchPlayer;
use app\models\Court;

class MatchController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                   [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'join'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $matches = GameMatch::find()
            ->where(['status' => GameMatch::STATUS_OPEN])
            ->andWhere(['>=', 'match_date', date('Y-m-d')])
            ->orderBy(['match_date' => SORT_ASC])
            ->all();

        return $this->render('index', ['matches' => $matches]);
    }

    public function actionCreate()
    {
        $model = new GameMatch();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->user->id;
            $model->status = GameMatch::STATUS_OPEN;

            if ($model->save()) {
                $mp = new MatchPlayer();
                $mp->match_id = $model->id;
                $mp->user_id = Yii::$app->user->id;
                $mp->save();

                Yii::$app->getSession()->setFlash('success', 'Match created successfully!');
                return $this->redirect(['index']);
            }
        }

        $courts = Court::find()->where(['status' => Court::STATUS_ACTIVE])->all();

        return $this->render('create', [
            'model' => $model,
            'courts' => $courts,
        ]);
    }

    public function actionView($id)
    {
        $match = GameMatch::findOne($id);

        if (!$match) {
            throw new \yii\web\NotFoundHttpException('Match not found.');
        }

        return $this->render('view', ['match' => $match]);
    }

    public function actionJoin($id)
    {
        $match = GameMatch::findOne($id);

        if (!$match) {
            throw new \yii\web\NotFoundHttpException('Match not found.');
        }

        if ($match->isFull()) {
            Yii::$app->getSession()->setFlash('error', 'This match is already full.');
            return $this->redirect(['index']);
        }

        $alreadyJoined = MatchPlayer::find()
            ->where(['match_id' => $id, 'user_id' => Yii::$app->user->id])
            ->exists();

        if ($alreadyJoined) {
            Yii::$app->getSession()->setFlash('error', 'You have already joined this match.');
            return $this->redirect(['index']);
        }

        $mp = new MatchPlayer();
        $mp->match_id = $id;
        $mp->user_id = Yii::$app->user->id;

        if ($mp->save()) {
            if ($match->isFull()) {
                $match->status = GameMatch::STATUS_FULL;
                $match->save();
            }
            Yii::$app->getSession()->setFlash('success', 'You have joined the match!');
        }

        return $this->redirect(['index']);
    }
}
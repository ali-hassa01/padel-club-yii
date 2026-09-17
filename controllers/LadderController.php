<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Team;
use app\models\LadderEntry;
use app\models\User;

class LadderController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create-team'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex($type = 'beginner')
    {
        $entries = LadderEntry::find()
            ->where(['ladder_type' => $type])
            ->orderBy(['points' => SORT_DESC, 'wins' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'entries' => $entries,
            'type' => $type,
        ]);
    }

    public function actionCreateTeam()
    {
        $team = new Team();

        if ($team->load(Yii::$app->request->post())) {
            $team->player1_id = Yii::$app->user->id;

            if ($team->save()) {
                $ladderType = Yii::$app->request->post('ladder_type', LadderEntry::LADDER_BEGINNER);

                $entry = new LadderEntry();
                $entry->team_id = $team->id;
                $entry->ladder_type = $ladderType;
                $entry->tier = LadderEntry::TIER_BRONZE;
                $entry->save();

                Yii::$app->getSession()->setFlash('success', 'Team created successfully and registered in the ladder!');
                return $this->redirect(['index', 'type' => $ladderType]);
            }
        }

        $players = User::find()->where(['!=', 'id', Yii::$app->user->id])->all();

        return $this->render('create-team', [
            'team' => $team,
            'players' => $players,
        ]);
    }
}
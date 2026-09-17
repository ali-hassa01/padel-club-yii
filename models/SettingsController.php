<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Setting;

class SettingsController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();
                        },
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $settings = Setting::find()->orderBy(['setting_key' => SORT_ASC])->all();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('Setting');
            foreach ($settings as $setting) {
                if (isset($post[$setting->id])) {
                    $setting->setting_value = $post[$setting->id];
                    $setting->save();
                }
            }
            Yii::$app->getSession()->setFlash('success', 'Settings updated successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('index', ['settings' => $settings]);
    }
}
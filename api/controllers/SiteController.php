<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use api\models\LoginForm;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'API';
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) {
            return $token;
        } else {
            return $model;
        }
    }

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }
}

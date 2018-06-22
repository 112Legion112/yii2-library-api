<?php
namespace api\controllers;

use common\models\BookLog;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;



class LibraryController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }


    public function actionTakeBook(){
        return BookLog::takeBook(Yii::$app->request->bodyParams['book_id'], Yii::$app->user->id);
    }

    public function actionReturnBook(){
        return BookLog::returnBook(Yii::$app->request->bodyParams['book_id'], Yii::$app->user->id);
    }

    public function verbs()
    {
        return [
            'take' => ['post'],
            'return' => ['post']
        ];
    }


}
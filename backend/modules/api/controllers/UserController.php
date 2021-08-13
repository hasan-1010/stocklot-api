<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use backend\modules\api\models\Login;
use backend\modules\api\models\Signup;
use common\models\User;
use yii\web\UploadedFile;
use common\components\Util;


class UserController extends ActiveController
{
	public $modelClass = 'common\models\User';

	public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['*'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            // 'authenticatior' => [
            //     'class'=> HttpBearerAuth:: className (), // Implementing access token authentication
            //     'except'=> ['options'],
            // ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'], 'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'], 'Access-Control-Request-Headers' => ['*'], 'Access-Control-Allow-Credentials' => null, 'Access-Control-Max-Age' => 86400, 'Access-Control-Expose-Headers' => []
                ],
            ],
        ]);
    } 

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['view'], $actions['update']);
        return $actions;
    }

    public function actionIndex()
    {
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 'success'];
        die();
    }

    public function actionLogin(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') ) {
            if ($token = $model->login()) {
                $user = User::findByUsername($model->username);
                return [
                    'user_id' => $user->id,
                    'status' => true,
                    'token' => $token,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'email' => $user->email,
                    'message' => 'Successfully Logged in'
                ];
            }
            return [
                'status' => false,
                'message' => 'Login Failed'
            ];
            
        } 
        return $model->getFirstErrors();
    }

    public function actionSignup()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') ) {
            if(strtolower($model->role) == 'admin') {
                return ['message' => 'Your cannot signup as an admin.', 'status' => false];
            }
            $model->file = UploadedFile::getInstanceByName("file");
            if($model->file){
                $model->avatar = Yii::$app->security->generateRandomString() . '.' . $model->file->extension;
            }

            if ($model->signup()) {
                Util::uploadFile($model->file, $model->avatar);
                return ['message' => 'Your registration has been completed.', 'status' => true];
            }
            else{
                return [
                	'message' => 'Your registration has been failed.', 
                	'error' => $model->getFirstErrors(),
                	'status' => false
                ];
            }
        }
        else {
            return $model->getFirstErrors();
        }
    }

}

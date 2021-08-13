<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\Category;
use yii\filters\auth\HttpBearerAuth;


class CategoryController extends ActiveController
{
	public $modelClass = 'common\models\Category';

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
            'authenticator' => [
                'class'=> HttpBearerAuth:: className (), // Implementing access token authentication
                'except'=> ['options'],
            ],
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

    public function actionGetCategory($parent, $level){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //Yii::error('found you');
       // return ['status' => true];
        $response = [];
        $models = Category::find()->where(['parent_id' => $parent, 'level' => $level])->all();
        //return top level category
        if ($parent == 0 ) {
            foreach ($models as $key => $model) {
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'parent_id' => $model->parent_id,
                    'level' => $model->level,
                    'thumb' => $model->thumb
                ];
                array_push($response, $data);
            }
            return $response;
        }
        //return second & third level category with nested array
        $cat2data = [];
        foreach ($models as $key => $model) {
            $cat3data = [];
            $FinalCategories = Category::find()->where(['parent_id' => $model->id])->all();
            foreach ($FinalCategories as $key => $category) {
                $data3 = [];
                $data3 = [
                    'id' => $category->id,
                    'title' => $category->title,
                    'parent_id' => $category->parent_id,
                    'level' => $category->level,
                    'thumb' => $category->thumb
                ];
                array_push($cat3data, $data3);
            }
            $cat2data = [
                'id' => $model->id,
                'title' => $model->title,
                'parent_id' => $model->parent_id,
                'level' => $model->level,
                'thumb' => $model->thumb,
                'sub' => $cat3data
            ];

            array_push($response, $cat2data);
        }
        return $response;
        
    }
}

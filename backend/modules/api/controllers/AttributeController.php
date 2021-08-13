<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\Stock;
use common\models\Category;
use yii\filters\auth\HttpBearerAuth;
use common\components\Util;
use common\models\StockQuantity;
use common\models\User;
use common\models\Brand;
use common\models\Color;
use common\models\Fabric;
use common\models\Quality;
use common\models\Measurement;


class AttributeController extends ActiveController
{
	public $modelClass = 'common\models\Brand';

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

    public function actionTest()
    {
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 'success'];
        die();
    }

    public function actionGetAllAttribute(){
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $data = [];

      $brands = [];
      $brandsModel = Brand::find()->all();
      foreach ($brandsModel as $key => $brand) {
        $brands[$brand->id] = $brand->title;
      }
      
      $data['brands'] = $brands;

      $colors = [];
      $colorsModel = Color::find()->all();
      foreach ($colorsModel as $key => $color) {
        $colors[$color->id] = $color->name;
      }

      $data['colors'] = $colors;

      $measurements = [];
      $measurementsModel = Measurement::find()->all();
      foreach ($measurementsModel as $key => $measurement) {
        $measurements[$measurement->id] = $measurement->name;
      }

      $data['measurements'] = $measurements;

      $qualities = [];
      $qualitiesModel = Quality::find()->all();
      foreach ($qualitiesModel as $key => $quality) {
        $qualities[$quality->id] = $quality->name;
      }

      $data['qualities'] = $qualities;

      $fabrics = [];
      $fabricsModel = Fabric::find()->all();
      foreach ($fabricsModel as $key => $fabric) {
        $fabrics[$fabric->id] = $fabric->name;
      }

      $data['fabrics'] = $fabrics;


      return ['status' => 'success', 'data' => $data];
      die();
    }

  
}

<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\Stock;
use common\models\Category;
use yii\filters\auth\HttpBearerAuth;
use common\components\Util;
use yii\web\UploadedFile;
use common\models\StockQuantity;
use common\models\User;
use common\models\Brand;


class StockController extends ActiveController
{
	public $modelClass = 'common\models\Stock';

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

    public function actionCreateStock(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new Stock();

        if($model->load(Yii::$app->request->post(), '') ) {
            $valid = $model->validate();

            if($valid){
                $transaction = \Yii::$app->db->beginTransaction();
                try{
                    $files = UploadedFile::getInstancesByName("files");
                    $images = [];
                    if (count($files) > 0) {
                        foreach ($files as $key => $file) {
                           array_push($images, Yii::$app->security->generateRandomString() . '.' . $file->extension);
                        }
                    }

                    $model->images = implode(',', $images);
                    if (!empty($model->images)) {
                        foreach ($files as $key => $file) {
                            Util::uploadFile($file, $images[$key]);
                        }  
                    }
                    if ($model->brand_id == 11) {
                        $brandModel = new Brand();
                        $brandModel->title = $model->other_brand;
                        if($brandModel->save()){
                            $model->brand_id = $brandModel->id;
                        }
                    }
                    if($flag = $model->save()) {
                        $colors = $Yii::$app->request->post('colors');
                        $quantities = $Yii::$app->request->post('sizes');
                        $transposeQtys = Stock::transpose($quantities);

                        foreach ($transposeQtys as $key => $qty) {
                            $modelQuantity = new StockQuantity();
                            $modelQuantity->stock_id = $model->id;
                            $modelQuantity->color_id   = $color[$key];
                            $modelQuantity->xsmall   = $qty[$key];
                            $modelQuantity->small   = $qty[$key];
                            $modelQuantity->medium  = $qty[$key];
                            $modelQuantity->large   = $qty[$key];
                            $modelQuantity->xlarge  = $qty[$key];
                            $modelQuantity->xxlarge = $qty[$key];
                            $modelQuantity->x3large   = $qty[$key];
                            $modelQuantity->x4large   = $qty[$key];
                            if(!($flag = $model->save())){
                                $transaction->rollBack();
                            }
                        }
                    }
                    if($flag){
                        $transaction->commit();
                        return ['status' => true];
                    }
                }catch (Exception $e) {
                    $transaction->rollBack();
                    return ['status' => false];
                }

            }
            
        }
        return array('status'=>false);

    }
    public function actionGetAllStock($category){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // return ['status' => true];
        // die();
        if($category == 0) $models = Stock::find()->all();  
        else $models = Stock::find()->where(['sub_cat_2_id' => $category])->all();
        
        $data = [];
        if($models){
            foreach ($models as $key => $model) {
                $user = User::find()->where(['id' => $model->user_id])->one();
                $stock_info = [
                    'id' => $model->id,
                    'user_id' => $model->user_id,
                    'user_phone' => $user->phone,
                    'user_email' => $user->email,
                    'main_cat_id' => $model->main_cat_id,
                    'sub_cat_id' => $model->sub_cat_id,
                    'sub_cat_2_id' => $model->sub_cat_2_id,
                    'price' => $model->price,
                    'currency' => $model->currency,
                    'brand_id' => $model->brand_id,
                    'measurement_id' => $model->measurement_id,
                    'no_of_color' => $model->no_of_color,
                    'fabric_id' => $model->fabric_id,
                    'quality_id' => $model->quality_id,
                    'gsm' => $model->gsm,
                    'quantity' => $model->quantity,
                    'descriptio' => $model->description,
                    'images' => $model->images,
                    'status' => $model->status,
                    'created_at' => $model->created_at, 
                    'updated_at' => $model->updated_at,
                ];

                array_push($data, $stock_info);
                
            }
            return ['status' => true, 'data' => $data];
            die();   
        }
        else{
            return ['status' => true, 'data' => $data];
            die();   
        }
    }
    // public function actionGetAllStock($category){
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     //Yii::error('found you');
    //    // return ['status' => true];
    //     $response = [];
    //     $models = Category::find()->where(['parent_id' => $parent, 'level' => $level])->all();
    //     //return top level category
    //     if ($parent == 0 ) {
    //         foreach ($models as $key => $model) {
    //             $data = [
    //                 'id' => $model->id,
    //                 'title' => $model->title,
    //                 'parent_id' => $model->parent_id,
    //                 'level' => $model->level,
    //                 'thumb' => $model->thumb
    //             ];
    //             array_push($response, $data);
    //         }
    //         return $response;
    //     }
    //     //return second & third level category with nested array
    //     $cat2data = [];
    //     foreach ($models as $key => $model) {
    //         $cat3data = [];
    //         $FinalCategories = Category::find()->where(['parent_id' => $model->id])->all();
    //         foreach ($FinalCategories as $key => $category) {
    //             $data3 = [];
    //             $data3 = [
    //                 'id' => $category->id,
    //                 'title' => $category->title,
    //                 'parent_id' => $category->parent_id,
    //                 'level' => $category->level,
    //                 'thumb' => $category->thumb
    //             ];
    //             array_push($cat3data, $data3);
    //         }
    //         $cat2data = [
    //             'id' => $model->id,
    //             'title' => $model->title,
    //             'parent_id' => $model->parent_id,
    //             'level' => $model->level,
    //             'thumb' => $model->thumb,
    //             'sub' => $cat3data
    //         ];

    //         array_push($response, $cat2data);
    //     }
    //     return $response;
        
    //  }
}

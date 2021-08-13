<?php

namespace backend\controllers;

use Yii;
use common\models\Stock;
use common\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Category;
use yii\helpers\ArrayHelper;
use common\models\StockQuantity;
use backend\models\Model;

use common\components\Util;
use yii\web\UploadedFile;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stock model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelsQuantity = $model->stockQuantities;

        return $this->render('view', [
            'model' => $model,
            'modelsQuantity' => $modelsQuantity
        ]);
    }

    /**
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stock();
        $modelsQuantity = [new StockQuantity];

        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->identity->id;
            $model->status = Stock::STATUS;

            $model->files = UploadedFile::getInstances($model, 'files');
            $images = [];
            if ($model->files) {
                foreach ($model->files as $key => $file) {
                   array_push($images, $file->basename.'_'.time() . '.' . $file->extension);
                }
            }
            

            $modelsQuantity = Model::createMultiple(StockQuantity::classname());
            Model::loadMultiple($modelsQuantity, Yii::$app->request->post());

            $valid = $model->validate();
            // echo $model->main_cat_id;
            // echo $model->sub_cat_id;
            // echo $model->sub_cat_2_id;
            // echo $model->brand_id;
            // echo $model->measurement_id;
            // echo $model->fabric_id;
            // echo $model->quality_id;
            // echo $model->price;
            
            $valid = Model::validateMultiple($modelsQuantity) && $valid;
            // echo $valid;
            // return;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    $model->no_of_color = count($modelsQuantity);
                    if (!empty($model->images)) {
                        $model->images = implode(',', $images);
                    }
                    
                    $flag = true;
                    if ($model->brand_id == 11) {
                        $brandModel = new Brand();
                        $brandModel->title = $model->other_brand;
                        if( ! ($flag = $brandModel->save()) ){
                            $transaction->rollBack();
                            return;
                        }
                        $model->brand_id = $brandModel->id;
                    }
                    if ($flag && $flag = $model->save()) {
                        if (!empty($model->images)) {
                            foreach ($model->files as $key => $file) {
                                Util::uploadFile($file, $images[$key]);
                            }  
                        }
                        

                        foreach ($modelsQuantity as $modelQuantity) {
                            $modelQuantity->stock_id = $model->id;
                            if (! ($flag = $modelQuantity->save())) {
                                $transaction->rollBack();
                                return;
                            }
                        }
                    }


                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }


        return $this->render('create', [
            'model' => $model,
            'modelsQuantity' => $modelsQuantity,
        ]);
    }

    /**
     * Updates an existing Stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsQuantity = $model->stockQuantities;


        $oldImages = $model->images;


        if ( $model->load(Yii::$app->request->post()) ) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $images = [];
            if ($model->files) {
                foreach ($model->files as $key => $file) {
                   array_push($images, $file->basename.'_'.time() . '.' . $file->extension);
                }
            }
            

            $oldIDs = ArrayHelper::map($modelsQuantity, 'id', 'id');
            $modelsQuantity = Model::createMultiple(StockQuantity::classname(), $modelsQuantity);
            Model::loadMultiple($modelsQuantity, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsQuantity, 'id', 'id')));
            

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsQuantity) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $model->no_of_color = count($modelsQuantity);
                    if (!empty($model->files)) {
                        $model->images = implode(',', $images);
                    }
                    // else{
                    //     $model->images = implode(',', $images);
                    // }
                    
                    $flag = true;
                    if ($model->brand_id == 11) {
                        $brandModel = new Brand();
                        $brandModel->title = $model->other_brand;
                        if( ! ($flag = $brandModel->save()) ){
                            $transaction->rollBack();
                            return;
                        }
                        $model->brand_id = $brandModel->id;
                    }
                    if ($flag && ($flag = $model->save())) {
                        if (!empty($model->files)) {
                            foreach (explode(',', $oldImages ) as $key => $oldImage) {
                                Util::deleteFile($oldImage);    
                            }
                            foreach ($model->files as $key => $file) {
                                Util::uploadFile($file, $images[$key]);
                            }
                            
                        }

                        if (!empty($deletedIDs)) {
                            StockQuantity::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsQuantity as $modelQuantity) {
                            //echo $modelQuantity->color_id;
                            $modelQuantity->stock_id = $model->id;
                            if (!($flag = $modelQuantity->save())) {
                                $transaction->rollBack();
                                return;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsQuantity' => $modelsQuantity,
        ]);
    }

    /**
     * Deletes an existing Stock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

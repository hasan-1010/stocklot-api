<?php

namespace backend\controllers;

use Yii;
use common\models\BuyerRequest;
use common\models\BuyerRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use common\components\Util;
use yii\web\UploadedFile;
use common\models\Brand;

/**
 * BuyerRequestController implements the CRUD actions for BuyerRequest model.
 */
class BuyerRequestController extends Controller
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
     * Lists all BuyerRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuyerRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BuyerRequest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BuyerRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BuyerRequest();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->identity->id;

            if ($model->brand_id == 11) {
                $brandModel = new Brand();
                $brandModel->title = $model->other_brand;
                if($brandModel->save()){
                    $model->brand_id = $brandModel->id;
                }
            }

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $model->image = $model->file.'_'.time() . '.' . $model->file->extension;
            }
            if ($model->save()) {
                if (!empty($model->image)) {
                    Util::uploadFile($model->file, $model->image);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BuyerRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
     
        if ($model->load(Yii::$app->request->post())) {

            if ($model->brand_id == 11) {
                $brandModel = new Brand();
                $brandModel->title = $model->other_brand;
                if($brandModel->save()){
                    $model->brand_id = $brandModel->id;
                }
            }

            $model->file = UploadedFile::getInstance($model, 'file');
            $oldImage = "";
            if ($model->file) {
                $oldImage = $model->image;
                $model->image = Yii::$app->security->generateRandomString() . '.' . $model->file->extension;
            }
            if ($model->save()) {
                if (!empty($model->file)) {
                    Util::deleteFile($oldImage);
                    Util::uploadFile($model->file, $model->image);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BuyerRequest model.
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
     * Finds the BuyerRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BuyerRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BuyerRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

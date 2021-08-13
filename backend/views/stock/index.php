<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

    <div class="row title-row">
        <div class="col-md-6 col-xs-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-6 col-xs-6">
            <p class="text-right">
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-success text-right']) ?>
            </p>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            'main_cat_id',
            'sub_cat_id',
            'sub_cat_2_id',
            'brand_id',
            'measurement_id',
            'fabric_id',
            'quality_id',
            'price',
            'currency',
            'gsm',
            'no_of_color',
            //'description:ntext',
            //'image_front',
            //'image_back',
            'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

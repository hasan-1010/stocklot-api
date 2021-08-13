<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BuyerRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buyer Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Buyer Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            //'image',
            //'description:ntext',
            'measurement_id',
            'color_id',
            'quantity',
            'fabric_id',
            'brand_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

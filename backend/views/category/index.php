<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <div class="row title-row">
        <div class="col-md-6  col-xs-6">
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
            'title',
            //'user_id',
            'level',
            'parent_id',
            //'description:ntext',
            //'thumb',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

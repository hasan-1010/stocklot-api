<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Util;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <div class="row title-row title-update">
        <div class="col-md-6 col-xs-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-6 col-xs-6">
            <p class="text-right">
                <?= Html::a('Add Another', ['create'], ['class' => 'btn btn-info']) ?>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div> 

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'user_id',
            'level',
            'parent_id',
            [
                'attribute' => 'description',
                'format' => 'html',
                'value' => function($model){
                    return $model->description;
                }
            ],
            [
                'attribute' => 'thumb',
                'format' => 'html',
                'value' => function($model){
                    return Html::img(Util::getUrlImage($model->thumb), ['width' => '200']);
                }
            ],
            [
              'attribute' => 'created_at',
               'value' => function ($model) {
                    return date('F d, Y h:i a', $model->created_at);
                },
            ], 
            [
              'attribute' => 'updated_at',
               'value' => function ($model) {
                    return date('F d, Y h:i a', $model->updated_at);
                },
            ],
        ],
    ]) ?>

</div>

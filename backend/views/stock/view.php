<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Util;
use common\models\Category;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stock-view">

    <div class="row title-row title-update">
        <div class="col-md-6 col-xs-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-6 col-xs-6">
            <p class="text-right">
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

    <div class="row">
        <div class="col-md-6">
            <div class="stock-image">
                <p>Gallery</p>
                <?php
                    echo newerton\fancybox\FancyBox::widget([
                        'target' => 'a[rel=fancybox]',
                        'helpers' => true,
                        'mouse' => true,
                        'config' => [
                            'maxWidth' => '90%',
                            'maxHeight' => '90%',
                            'playSpeed' => 7000,
                            'padding' => 0,
                            'fitToView' => false,
                            'width' => '70%',
                            'height' => '70%',
                            'autoSize' => false,
                            'closeClick' => false,
                            'openEffect' => 'elastic',
                            'closeEffect' => 'elastic',
                            'prevEffect' => 'elastic',
                            'nextEffect' => 'elastic',
                            'closeBtn' => false,
                            'openOpacity' => true,
                            'helpers' => [
                                'title' => ['type' => 'float'],
                                'buttons' => [],
                                'thumbs' => ['width' => 68, 'height' => 50],
                                'overlay' => [
                                    'css' => [
                                        'background' => 'rgba(0, 0, 0, 0.8)'
                                    ]
                                ]
                            ],
                        ]
                    ]);
                    $images = explode(',', $model->images);
                    foreach ($images as $key => $image) {
                        $class = ($key==0)?"main-image":"thumb-image";
                        echo '<div class="'.$class.'">'.Html::a(Html::img(Util::getUrlImage($image), ['width' => '100%']), Util::getUrlImage($image), ['rel' => 'fancybox']).'</div>';
                    }
                    
                    ?>
            </div>
        </div>
        <div class="col-md-6">
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th><span class="square"></span>Stock ID:</th>
                        <td><?= $model->id ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Stock Owner:</th>
                        <td><?= User::getUsername($model->user_id) ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Category:</th>
                        <td><?= Category::getCategoryName($model->main_cat_id) ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Category:</th>
                        <td><?= Category::getCategoryName($model->sub_cat_id) ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Category:</th>
                        <td><?= Category::getCategoryName($model->sub_cat_2_id) ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Price:</th>
                        <td><?= $model->price ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Currency:</th>
                        <td><?= $model->currency ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Quantity:</th>
                        <td><?= $model->quantity ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Brand:</th>
                        <td><?= $model->brand_id ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Measurement:</th>
                        <td><?= $model->measurement_id ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Fabric:</th>
                        <td><?= $model->fabric_id ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>GSM:</th>
                        <td><?= $model->gsm ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Quality:</th>
                        <td><?= $model->quality_id ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>No of Color:</th>
                        <td><?= $model->no_of_color ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Status:</th>
                        <td><?= $model->status ?></td>
                    </tr>
                    <tr>
                        <th><span class="square"></span>Added</th>
                        <td><?= Util::formatDateTime('F d, Y h:i a', $model->created_at) ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= $model->description ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="product-color-quantity">
                <h3>Product Color & Quantity</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Small</th>
                            <th>Medium</th>
                            <th>Large</th>
                            <th>XLarge</th>
                            <th>XXLarge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modelsQuantity as $key => $modelQuantity) { ?>
                        <tr>
                            <th><?= $modelQuantity->color_id ?></th>
                            <td><?= $modelQuantity->xsmall ?></td>
                            <td><?= $modelQuantity->small ?></td>
                            <td><?= $modelQuantity->medium ?></td>
                            <td><?= $modelQuantity->large ?></td>
                            <td><?= $modelQuantity->xlarge ?></td>
                            <td><?= $modelQuantity->xxlarge ?></td>
                            <td><?= $modelQuantity->x3large ?></td>
                            <td><?= $modelQuantity->x4large ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php // DetailView::widget([
        // 'model' => $model,
        // 'attributes' => [
        //     'id',
        //     'user_id',
        //     'category_id',
        //     'per_unit_price',
        //     'description:ntext',
        //     'image_front',
        //     'image_back',
        //     'status',
        //     'created_at',
        //     'updated_at',
        // ],
    //]) ?>

</div>


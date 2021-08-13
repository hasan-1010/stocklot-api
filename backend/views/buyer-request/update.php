<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BuyerRequest */

$this->title = 'Update Buyer Request: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Buyer Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="buyer-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BuyerRequest */

$this->title = 'Create Buyer Request';
$this->params['breadcrumbs'][] = ['label' => 'Buyer Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

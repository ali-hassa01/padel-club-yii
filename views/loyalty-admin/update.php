<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LoyaltyLog $model */

$this->title = 'Update Loyalty Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Loyalty Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loyalty-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

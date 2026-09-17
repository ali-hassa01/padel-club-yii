<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GameMatch $model */

$this->title = 'Update Game Match: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-match-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LadderEntry $model */

$this->title = 'Create Ladder Entry';
$this->params['breadcrumbs'][] = ['label' => 'Ladder Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ladder-entry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LadderEntrySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ladder-entry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'team_id') ?>

    <?= $form->field($model, 'ladder_type') ?>

    <?= $form->field($model, 'tier') ?>

    <?= $form->field($model, 'rank_position') ?>

    <?php // echo $form->field($model, 'points') ?>

    <?php // echo $form->field($model, 'wins') ?>

    <?php // echo $form->field($model, 'losses') ?>

    <?php // echo $form->field($model, 'streak') ?>

    <?php // echo $form->field($model, 'last_active_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

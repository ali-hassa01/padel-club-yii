<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LadderEntry $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ladder-entry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'team_id')->textInput() ?>

    <?= $form->field($model, 'ladder_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rank_position')->textInput() ?>

    <?= $form->field($model, 'points')->textInput() ?>

    <?= $form->field($model, 'wins')->textInput() ?>

    <?= $form->field($model, 'losses')->textInput() ?>

    <?= $form->field($model, 'streak')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

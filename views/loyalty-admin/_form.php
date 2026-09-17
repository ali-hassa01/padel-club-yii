<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoyaltyLog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="loyalty-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'year_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hours_played')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reward_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reward_used')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

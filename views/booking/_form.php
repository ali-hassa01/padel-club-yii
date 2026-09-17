<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use app\models\Court;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Booking */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="booking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'court_id')->dropDownList(
        ArrayHelper::map(Court::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Court']
    ) ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'),
        ['prompt' => '-- Guest Booking (no account) --']
    ) ?>

    <?= $form->field($model, 'guest_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guest_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guest_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booking_date')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'start_time')->textInput(['type' => 'time']) ?>

    <?= $form->field($model, 'end_time')->textInput(['type' => 'time']) ?>

    <?= $form->field($model, 'game_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_status')->dropDownList([
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
    ]) ?>

    <?= $form->field($model, 'payment_amount')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
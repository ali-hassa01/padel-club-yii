<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="player-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'skill_level')->dropDownList([
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
    ]) ?>
    <?= $form->field($model, 'role')->dropDownList([
        'player' => 'Player',
        'admin' => 'Admin',
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Active',
        0 => 'Inactive',
    ]) ?>

    <?php if ($model->isNewRecord): ?>
        <div class="form-group field-user-password">
            <label class="form-label" for="user-password">Password</label>
            <input type="password" id="user-password" name="password" class="form-control">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
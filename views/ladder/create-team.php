<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $team app\models\Team */
/* @var $players app\models\User[] */

$this->title = 'Create Team & Join Ladder';
?>
<div class="ladder-create-team">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($team, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($team, 'player2_id')->dropDownList(
        ArrayHelper::map($players, 'id', 'username'),
        ['prompt' => 'Select your partner']
    ) ?>

    <div class="form-group">
        <label class="form-label">Ladder</label>
        <select name="ladder_type" class="form-select">
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
        </select>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Create Team & Join', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
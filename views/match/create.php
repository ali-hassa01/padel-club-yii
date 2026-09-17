<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Match */
/* @var $courts app\models\Court[] */

$this->title = 'Create Match';
?>
<div class="match-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'court_id')->dropDownList(
        ArrayHelper::map($courts, 'id', 'name'),
        ['prompt' => 'Select Court (optional)']
    ) ?>

    <?= $form->field($model, 'match_date')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'start_time')->textInput(['type' => 'time']) ?>
    <?= $form->field($model, 'end_time')->textInput(['type' => 'time']) ?>

    <?= $form->field($model, 'skill_level')->dropDownList([
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'any' => 'Any',
    ]) ?>

    <?= $form->field($model, 'slots_needed')->input('number', ['min' => 1, 'max' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create Match', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
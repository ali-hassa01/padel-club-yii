<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $settings app\models\Setting[] */

$this->title = 'Rules & Settings';
?>
<div class="settings-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Configure loyalty thresholds and ladder tier boundaries used across the app.</p>

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-bordered" style="max-width: 800px;">
        <thead>
            <tr>
                <th>Setting</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($settings as $setting): ?>
                <tr>
                    <td><?= Html::encode($setting->setting_key) ?></td>
                    <td>
                        <?= Html::textInput("Setting[{$setting->id}]", $setting->setting_value, ['class' => 'form-control']) ?>
                    </td>
                    <td><?= Html::encode($setting->description) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save Settings', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
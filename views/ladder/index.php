<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $entries app\models\LadderEntry[] */
/* @var $type string */

$this->title = 'Ladder - ' . ucfirst($type);
?>
<div class="ladder-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Beginner Ladder', ['index', 'type' => 'beginner'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
        <?= Html::a('Intermediate Ladder', ['index', 'type' => 'intermediate'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Create Team & Join Ladder', ['create-team'], ['class' => 'btn btn-sm btn-success float-end']) ?>
        <?php endif; ?>
    </p>

    <?php if (empty($entries)): ?>
        <p>There are no teams in this ladder yet.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Team</th>
                    <th>Tier</th>
                    <th>Points</th>
                    <th>W/L</th>
                    <th>Streak</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $i => $entry): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?= $entry->team ? Html::encode($entry->team->name) : '-' ?>
                            <br>
                            <small>
                                <?= $entry->team && $entry->team->player1 ? Html::encode($entry->team->player1->username) : '' ?>
                                &amp;
                                <?= $entry->team && $entry->team->player2 ? Html::encode($entry->team->player2->username) : '' ?>
                            </small>
                        </td>
                        <td><?= ucfirst($entry->tier) ?></td>
                        <td><?= $entry->points ?></td>
                        <td><?= $entry->wins ?>W / <?= $entry->losses ?>L</td>
                        <td><?= $entry->streak ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
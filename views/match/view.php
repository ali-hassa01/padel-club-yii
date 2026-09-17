<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $match app\models\GameMatch */

$this->title = 'Match Details';
?>
<div class="match-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered" style="max-width: 600px;">
        <tr>
            <th>Date</th>
            <td><?= Html::encode($match->match_date) ?></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><?= substr($match->start_time, 0, 5) ?> - <?= substr($match->end_time, 0, 5) ?></td>
        </tr>
        <tr>
            <th>Court</th>
            <td><?= $match->court ? Html::encode($match->court->name) : 'Not specified' ?></td>
        </tr>
        <tr>
            <th>Skill Level</th>
            <td><?= Html::encode($match->skill_level) ?></td>
        </tr>
        <tr>
            <th>Created By</th>
            <td><?= $match->creator ? Html::encode($match->creator->username) : '-' ?></td>
        </tr>
        <tr>
            <th>Players Needed</th>
            <td><?= $match->slots_needed ?></td>
        </tr>
        <tr>
            <th>Players Joined</th>
            <td><?= $match->getJoinedCount() ?> / <?= $match->slots_needed ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= Html::encode($match->status) ?></td>
        </tr>
    </table>

    <h4>Joined Players</h4>
    <?php if (empty($match->players)): ?>
        <p>No players yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($match->players as $player): ?>
                <li><?= Html::encode($player->username) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!Yii::$app->user->isGuest && !$match->isFull()): ?>
        <?= Html::a('Join This Match', ['join', 'id' => $match->id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>

    <?= Html::a('Back to Matches', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>
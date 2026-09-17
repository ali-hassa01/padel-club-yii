<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $matches app\models\Match[] */

$this->title = 'Open Matches';
?>
<div class="match-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p><?= Html::a('Create New Match', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?php endif; ?>

    <?php if (empty($matches)): ?>
        <p>There are no open matches at the moment.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Court</th>
                    <th>Skill Level</th>
                    <th>Players</th>
                    <th>Created By</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $match): ?>
                    <tr>
                        <td><?= Html::encode($match->match_date) ?></td>
                        <td><?= substr($match->start_time, 0, 5) ?> - <?= substr($match->end_time, 0, 5) ?></td>
                        <td><?= $match->court ? Html::encode($match->court->name) : '-' ?></td>
                        <td><?= Html::encode($match->skill_level) ?></td>
                        <td><?= $match->getJoinedCount() ?> / <?= $match->slots_needed ?></td>
                        <td><?= $match->creator ? Html::encode($match->creator->username) : '-' ?></td>
                                               <td>
                            <?= Html::a('View', ['view', 'id' => $match->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                            <?php if (!Yii::$app->user->isGuest && !$match->isFull()): ?>
                                <?= Html::a('Join', ['join', 'id' => $match->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $currentLog app\models\LoyaltyLog|null */
/* @var $availableReward app\models\LoyaltyLog|null */
/* @var $history app\models\LoyaltyLog[] */

$this->title = 'My Loyalty';
?>
<div class="loyalty-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card mb-4" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title">Hours This Month</h5>
            <p class="card-text" style="font-size: 24px;">
                <?= $currentLog ? number_format($currentLog->hours_played, 1) : '0.0' ?> hours
            </p>
            <p class="text-muted">
                12-14 hours = 20% discount | 15+ hours = Free Slot
            </p>
        </div>
    </div>

    <?php if ($availableReward): ?>
        <div class="alert alert-success" style="max-width: 500px;">
            <strong>🎉 You have a reward available!</strong><br>
            <?php if ($availableReward->reward_type === 'free_slot'): ?>
                                A Free Slot (from <?= $availableReward->year_month ?>)
            <?php else: ?>
                20% Discount (from <?= $availableReward->year_month ?>)
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary" style="max-width: 500px;">
            No reward available at the moment.
        </div>
    <?php endif; ?>

    <h3>History</h3>
    <?php if (empty($history)): ?>
        <p>No history available.</p>
    <?php else: ?>
        <table class="table table-bordered" style="max-width: 600px;">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Hours</th>
                    <th>Reward</th>
                    <th>Used?</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $log): ?>
                    <tr>
                        <td><?= Html::encode($log->year_month) ?></td>
                        <td><?= number_format($log->hours_played, 1) ?></td>
                        <td><?= $log->reward_type ? Html::encode($log->reward_type) : '-' ?></td>
                        <td><?= $log->reward_used ? 'Yes' : 'No' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
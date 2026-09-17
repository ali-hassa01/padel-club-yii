<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $upcomingBookings app\models\Booking[] */
/* @var $myMatches app\models\GameMatch[] */
/* @var $myTeams app\models\Team[] */
/* @var $currentLoyalty app\models\LoyaltyLog|null */

$this->title = 'My Dashboard';
?>
<div class="profile-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Welcome, <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong>
        — <?= Html::a('Edit Profile', ['edit'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
    </p>

    <div class="row">
        <div class="col-md-4">
            <h4>Loyalty This Month</h4>
            <p><?= $currentLoyalty ? number_format($currentLoyalty->hours_played, 1) : '0.0' ?> hours</p>
            <?= Html::a('View Loyalty Details', ['/loyalty/index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
        </div>

        <div class="col-md-4">
            <h4>My Teams</h4>
            <?php if (empty($myTeams)): ?>
                <p>No teams yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($myTeams as $team): ?>
                        <li><?= Html::encode($team->name) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?= Html::a('Go to Ladder', ['/ladder/index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
        </div>

        <div class="col-md-4">
            <h4>My Matches</h4>
            <p><?= count($myMatches) ?> match(es) joined</p>
            <?= Html::a('View Matches', ['/match/index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
        </div>
    </div>

    <hr>

    <h3>Upcoming Bookings</h3>
    <?php if (empty($upcomingBookings)): ?>
        <p>No upcoming bookings.</p>
    <?php else: ?>
        <table class="table table-bordered" style="max-width: 700px;">
            <thead>
                <tr>
                    <th>Court</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcomingBookings as $booking): ?>
                    <tr>
                        <td><?= $booking->court ? Html::encode($booking->court->name) : '-' ?></td>
                        <td><?= Html::encode($booking->booking_date) ?></td>
                        <td><?= substr($booking->start_time, 0, 5) ?> - <?= substr($booking->end_time, 0, 5) ?></td>
                        <td><?= Html::encode($booking->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
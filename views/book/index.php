<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $courts app\models\Court[] */
/* @var $courtId int|null */
/* @var $date string|null */
/* @var $slots array */
/* @var $selectedCourt app\models\Court|null */

$this->title = 'Book a Court';
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <form method="get" action="<?= Url::to(['book/index']) ?>" class="row g-3 mb-4">
                <input type="hidden" name="r" value="book/index">
        <div class="col-md-4">
            <label class="form-label">Select Court</label>
            <select name="court_id" class="form-select" required>
                <option value="">-- Select Court --</option>
                <?php foreach ($courts as $court): ?>
                    <option value="<?= $court->id ?>" <?= (string)$courtId === (string)$court->id ? 'selected' : '' ?>>
                        <?= Html::encode($court->name) ?> (Rs. <?= $court->price_per_slot ?>/slot)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Select Date</label>
            <input type="date" name="date" value="<?= Html::encode($date) ?>" class="form-control" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Check Availability</button>
        </div>
    </form>

    <?php if ($selectedCourt && !empty($slots)): ?>
        <h3>Available Slots — <?= Html::encode($selectedCourt->name) ?> on <?= Html::encode($date) ?></h3>

        <form method="post" action="<?= Url::to(['book/confirm']) ?>">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            <input type="hidden" name="court_id" value="<?= $selectedCourt->id ?>">
            <input type="hidden" name="booking_date" value="<?= Html::encode($date) ?>">
            <input type="hidden" name="end_time" id="end_time_input">

            <div class="row row-cols-2 row-cols-md-4 g-2 mb-3">
                <?php foreach ($slots as $i => $slot): ?>
                    <div class="col">
                        <input type="radio" name="start_time" value="<?= $slot['start'] ?>"
                            data-end="<?= $slot['end'] ?>"
                            class="btn-check slot-radio"
                            id="slot_<?= $i ?>"
                            autocomplete="off"
                            <?= $slot['available'] ? '' : 'disabled' ?> required>
                        <label class="btn btn-outline-<?= $slot['available'] ? 'success' : 'secondary' ?> w-100 <?= $slot['available'] ? '' : 'disabled' ?>" for="slot_<?= $i ?>">
                            <?= $slot['label'] ?><?= $slot['available'] ? '' : ' (Booked)' ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Game Type (optional)</label>
                <input type="text" name="game_type" class="form-control" placeholder="e.g. Singles, Doubles">
            </div>

                        <?php if (!Yii::$app->user->isGuest && isset($availableReward) && $availableReward): ?>
                <div class="alert alert-success">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="use_reward" value="1" id="use_reward_check">
                        <label class="form-check-label" for="use_reward_check">
                            <?php if ($availableReward->reward_type === 'free_slot'): ?>
                                Use my Free Slot reward for this booking
                            <?php else: ?>
                                Use my 20% Discount reward for this booking
                            <?php endif; ?>
                        </label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->user->isGuest): ?>
                <h5>Guest Details</h5>
                <div class="mb-2">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="guest_name" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" name="guest_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="guest_phone" class="form-control" required>
                </div>
            <?php else: ?>
                <p>Booking as: <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong></p>
            <?php endif; ?>

            <button type="submit" class="btn btn-success">Confirm Booking</button>
        </form>

        <script>
        document.querySelectorAll('.slot-radio').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.getElementById('end_time_input').value = this.dataset.end;
            });
        });
        </script>
    <?php elseif ($selectedCourt): ?>
        <p>No slots are configured for this court.</p>
    <?php endif; ?>
</div>
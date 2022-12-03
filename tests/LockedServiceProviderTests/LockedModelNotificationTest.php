<?php

use Illuminate\Support\Facades\Mail;
use Sfolador\Locked\Tests\TestClasses\TestModel;
use Sfolador\Locked\Tests\TestClasses\TestNotification;

it('send notifications to locked models if enabled', function () {
    Mail::fake();
    Notification::fake();
    config()->set('locked.prevent_notifications_to_locked_objects', false);

    $model = TestModel::factory()->locked()->create();
    $model->notify(new TestNotification());

    Notification::assertSentTo($model, TestNotification::class);
});

it('does not send notifications to locked model if disabled', function () {
    config()->set('locked.prevent_notifications_to_locked_objects', true);

    $model = TestModel::factory()->locked()->create();
    $model->notify(new TestNotification());

    expect($model->notifications)->toBeEmpty();
});

<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can choose a custom column to save locked state', function () {
    $defaultValue = config()->get('locked.locking_column');
    config()->set('locked.locking_column', 'custom_locked_at');
    $model = TestModel::factory()->locked()->create();

    expect($model->isLocked())->toBeTrue()
        ->and($model->custom_locked_at)->not->toBeNull()
        ->and($model->locked_at)->toBeNull();
    config()->set('locked.locking_column', $defaultValue);
});

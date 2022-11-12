<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can choose a custom column to save locked state', function () {
    config()->set('locked.model_locked_column', 'custom_locked_at');
    $model = TestModel::factory()->locked()->create();

    expect($model->isLocked())->toBeTrue()
        ->and($model->custom_locked_at)->not->toBeNull()
        ->and($model->locked_at)->toBeNull();
});

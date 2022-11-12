<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can be locked', function () {
    $model = TestModel::factory()->unlocked()->create();
    $model->lock();
    expect($model->isLocked())->toBeTrue();
    expect($model->isNotUnlocked())->toBeTrue();
});

it('can be unlocked', function () {
    $model = TestModel::factory()->locked()->create();
    $model->unlock();
    expect($model->isUnlocked())->toBeTrue();
    expect($model->isNotLocked())->toBeTrue();
});

it('can be locked or unlocked with a toggle', function () {
    $model = TestModel::factory()->unlocked()->create();
    $model->toggleLock();
    expect($model->isLocked())->toBeTrue();
    $model->toggleLock();
    expect($model->isUnlocked())->toBeTrue();
});

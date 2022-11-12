<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can be locked', function () {
   $model = new TestModel();
   $model->lock();
   expect($model->isLocked())->toBeTrue();
   expect($model->isNotUnlocked())->toBeTrue();
});

it('can be unlocked', function () {
    $model = new TestModel();
    $model->lock();
    $model->unlock();
    expect($model->isUnlocked())->toBeTrue();
    expect($model->isNotLocked())->toBeTrue();
});

it('can be locked or unlocked with a toggle', function () {
    $model = new TestModel();
    $model->toggleLock();
    expect($model->isLocked())->toBeTrue();
    $model->toggleLock();
    expect($model->isUnlocked())->toBeTrue();
});

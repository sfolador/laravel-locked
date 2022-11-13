<?php

use Sfolador\Locked\Exceptions\CannotUnlockException;
use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can get the locked column name', function () {
    $locked = app('locked');
    expect($locked->getLockedColumnName())->toBe('locked_at');
});

it('can get the locked column name from config', function () {
    $locked = app('locked');
    config()->set('locked.locking_column', 'custom_locked_at');
    expect($locked->getLockedColumnName())->toBe('custom_locked_at');
    config()->set('locked.locking_column', 'locked_at');
});

it('can tell if the unlock procedure is allowed', function () {
    $locked = app('locked');
    expect($locked->unlockAllowed())->toBeTrue();
});

it('can tell if the unlock procedure is not allowed', function () {
    $locked = app('locked');
    config()->set('locked.unlock_allowed', false);
    expect($locked->unlockAllowed())->toBeFalse();
    config()->set('locked.unlock_allowed', true);
});

it('can tell what classes can be unlocked', function () {
    $locked = app('locked');
    expect($locked->classesThatCanBeUnlocked())->toBe([]);
});

it('can detect if an object can be unlocked', function () {
    $locked = app('locked');
    $model = TestModel::factory()->create();
    expect($locked->canBeUnlocked($model))->toBeTrue();
});

it('can detect if a locked object can be unlocked', function () {
    $locked = app('locked');
    $model = TestModel::factory()->create();
    $model->lock();
    expect($locked->canBeUnlocked($model))->toBeTrue();
});

it('can detect if a locked object cannot be unlocked', function () {
    $locked = app('locked');
    $model = TestModel::factory()->create();
    $model->lock();
    expect($locked->cannotBeUnlocked($model))->toBeFalse();
});

it('can set unlockable classes in the configuration', function () {
    $unlockable = [
        TestModel::class,
    ];

    config()->set('locked.can_be_unlocked', $unlockable);
    $locked = app('locked');
    expect($locked->classesThatCanBeUnlocked())->toBe($unlockable);
});

it('can unlock a model if its class is in the unlockable list', function () {
    $unlockable = [
        TestModel::class,
    ];

    config()->set('locked.can_be_unlocked', $unlockable);
    config()->set('locked.unlock_allowed', false);
    $locked = app('locked');
    $model = TestModel::factory()->create();
    expect($locked->canBeUnlocked($model))->toBeTrue();
});

it('an exception will be raised if a locked model cannot be unlocked', function () {
    config()->set('locked.unlock_allowed', false);

    $locked = app('locked');
    $model = TestModel::factory()->locked()->create();
    $model->unlock();
})->throws(CannotUnlockException::class);

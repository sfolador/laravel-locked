<?php

use Illuminate\Support\Facades\Event;
use Sfolador\Locked\Exceptions\LockedModelException;
use Sfolador\Locked\Tests\TestClasses\NormalModel;
use Sfolador\Locked\Tests\TestClasses\TestModel;

it('an event is triggered for model save', function () {
    Event::fake();
    $t = new TestModel();
    $t->save();
    Event::assertDispatched('eloquent.saving: '.TestModel::class);
    expect(Event::hasListeners('eloquent.saving: '.TestModel::class))->toBeTrue();
});

it('an exception is raised if a locked model is unlocked manually', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);
    $t = new TestModel();
    $t->lock();

    $t->locked_at = null;
    $t->save();
    config()->set('locked.prevent_modifications_on_locked_objects', false);
})->throws(LockedModelException::class);

it('an exception is raised if a locked model is unlocked automatically', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->lock();
    $t->unlock();
    config()->set('locked.prevent_modifications_on_locked_objects', false);
})->throws(LockedModelException::class);

it('an exception is raised if a locked model is deleted', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->lock();
    $t->delete();
    config()->set('locked.prevent_modifications_on_locked_objects', false);
})->throws(LockedModelException::class);

//it('an exception is raised if a locked model is replicated', function () {
//    config()->set('locked.prevent_modifications_on_locked_objects', true);
//    $t = new TestModel();
//    $t->lock();
//    $t->replicate();
//    config()->set('locked.prevent_modifications_on_locked_objects', false);
//})->throws(LockedModelException::class);

it('can lock an object if allowed by the configuration', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', false);

    $t = new TestModel();
    $t->lock();
    $t->save();

    expect($t->isLocked())->toBeTrue();
});

it('model that do not use the trait will not be affected by exceptions on events', function () {
    Event::fake();
    $m = new NormalModel();
    $m->save();
    Event::assertDispatched('eloquent.saving: '.NormalModel::class);
});

it('model that do not use the trait will not be affected by exceptions on events even with config in place', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);
    $m = new NormalModel();
    $m->save();
    config()->set('locked.prevent_modifications_on_locked_objects', false);
    expect($m->id)->not->toBeNull();
});

it('can delete a locked object if allowed by the configuration', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', false);

    $t = new TestModel();
    $t->lock();
    $tid = $t->id;
    $t->delete();

    expect(TestModel::find($tid))->toBeNull();
});

it('can delete a normal object even if forbidden by the configuration', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new NormalModel();
    $t->save();
    $tid = $t->id;
    $t->delete();

    expect(NormalModel::find($tid))->toBeNull();

    config()->set('locked.prevent_modifications_on_locked_objects', false);
});

it('a locked model can be saved only if there are no modifications', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->lock();
    $t->save();

    config()->set('locked.prevent_modifications_on_locked_objects', false);
    expect($t->isLocked())->toBeTrue();
});

it('a model can be deleted only if it is not locked', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->save();
    $t->delete();

    expect(TestModel::find($t->id))->toBeNull();

    config()->set('locked.prevent_modifications_on_locked_objects', false);
});

it('a model cannot be replicated if locked', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->lock();
    $t->replicate();

    config()->set('locked.prevent_modifications_on_locked_objects', false);
})->throws(LockedModelException::class);

it('a model can be replicated if not locked', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new TestModel();
    $t->save();
    $other = $t->replicate();
    $other->save();

    config()->set('locked.prevent_modifications_on_locked_objects', false);
    expect($other->id)->not->toBe($t->id)->and($other->id)->not->toBeNull();
});

it('a model can be replicated if the configuration is open', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', false);

    $t = new TestModel();
    $t->lock();
    $o = $t->replicate();
    $o->save();
    expect($t->isLocked())->toBeTrue();
    expect($o->isLocked())->toBeTrue();
});

it('a model that does not have the haslocks trait can be replicated', function () {
    config()->set('locked.prevent_modifications_on_locked_objects', true);

    $t = new NormalModel();
    $t->save();
    $other = $t->replicate();
    $other->save();
    expect($t->id)->not->toBeNull();
    expect($other->id)->not->toBeNull();
    expect($other->id)->not->toBe($t->id);
});

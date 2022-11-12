<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can filter a model with a scope to see if it is locked', function () {
    $model = TestModel::factory()->locked()->create();

    $model2 = TestModel::factory()->unlocked()->create();

    $locked = TestModel::locked()->get();
    expect($locked->count())->toBe(1);
    expect($locked->first()->id)->toBe($model->id);
});

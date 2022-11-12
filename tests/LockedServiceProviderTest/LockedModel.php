<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('can be locked', function () {
   $model = new TestModel();
   $model->lock();
   expect($model->isLocked())->toBeTrue();
});

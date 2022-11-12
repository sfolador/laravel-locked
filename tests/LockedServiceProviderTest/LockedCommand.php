<?php

use Sfolador\Locked\Tests\TestClasses\TestModel;

it('cannot invoke the command for a model that does not exist',function (){
    $this->artisan('lock:add', ['model' => 'App\Models\NotexistingModel'])
        ->expectsOutput('Model App\Models\NotexistingModel does not exist')
        ->assertExitCode(1);
});

it('can invoke the command for a model that exists',function (){
    $this->artisan('lock:add', ['model' => TestModel::class])
        ->assertExitCode(0);
});

<?php

use Illuminate\Console\Command;
use Sfolador\Locked\Tests\TestClasses\Another;



it('cannot invoke the command for a class that does not exist', function () {
    $this->artisan('lock:add', ['model' => 'App\Models\NotExistentModel'])
        ->expectsOutput('Model App\Models\NotExistentModel does not exist')
        ->assertExitCode(Command::FAILURE);
});

it('can create a migration for a model', function () {

    $this->artisan('migrate:reset');
    $this->artisan('lock:add', ['model' => Another::class])
        ->assertExitCode(Command::SUCCESS);
    $another = new Another();

    $this->assertFileExists(database_path('migrations/'.date('Y_m_d_His').'_add_locked_columns_to_'.$another->getTable().'.php'));
    $this->artisan('migrate');

    $another->lock();

    expect($another->isLocked())->toBeTrue();

    $this->artisan('migrate:reset');
});

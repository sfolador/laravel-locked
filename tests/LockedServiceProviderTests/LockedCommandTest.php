<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Sfolador\Locked\Tests\TestClasses\Another;
use function Spatie\PestPluginTestTime\testTime;

it('cannot invoke the command for a class that does not exist', function () {

    $defaultConfig = config('locked.default_namespace');

    $this->artisan('lock:add', ['model' => 'NotExistentModel'])
        ->expectsOutput('Model '.$defaultConfig.'\NotExistentModel does not exist')
        ->assertExitCode(Command::FAILURE);
});

it('can create a migration for a model', function () {
    testTime()->freeze('2020-01-01 00:00:00');

    $this->artisan('lock:add', ['model' => "Another", '--namespace' => 'Sfolador\Locked\Tests\TestClasses'])
        ->assertExitCode(Command::SUCCESS);
    $another = new Another();

    $date = now()->format('Y_m_d_His');
    $this->assertFileExists(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));

    Storage::delete(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));
});

it('can use the default namespace', function () {
    testTime()->freeze('2020-01-01 00:00:00');

    $defaultConfig = config('locked.default_namespace');
    config()->set('locked.default_namespace', 'Sfolador\Locked\Tests\TestClasses');

    $this->artisan('lock:add', ['model' => "Another"])
        ->assertExitCode(Command::SUCCESS);
    $another = new Another();

    $date = now()->format('Y_m_d_His');
    $this->assertFileExists(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));

    Storage::delete(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));

    config()->set('locked.default_namespace', $defaultConfig);
});

<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Sfolador\Locked\Tests\TestClasses\Another;
use function Spatie\PestPluginTestTime\testTime;

it('cannot invoke the command for a class that does not exist', function () {
    $this->artisan('lock:add', ['model' => 'App\Models\NotExistentModel'])
        ->expectsOutput('Model App\Models\NotExistentModel does not exist')
        ->assertExitCode(Command::FAILURE);
});

it('can create a migration for a model', function () {

    testTime()->freeze('2020-01-01 00:00:00');

    $this->artisan('lock:add', ['model' => Another::class])
        ->assertExitCode(Command::SUCCESS);
    $another = new Another();

    $date = now()->format('Y_m_d_His');
    $this->assertFileExists(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));

    Storage::delete(database_path('migrations/'.$date.'_add_locked_columns_to_'.$another->getTable().'.php'));
});

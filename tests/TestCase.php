<?php

namespace Sfolador\Locked\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Orchestra\Testbench\artisan;
use Orchestra\Testbench\TestCase as Orchestra;
use Sfolador\Locked\LockedServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sfolador\\Locked\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LockedServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testbench');
        config()->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-locked_table.php.stub';
        $migration->up();
        */
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        artisan($this, 'migrate', ['--database' => 'testbench']);

        $this->beforeApplicationDestroyed(
            fn () => artisan($this, 'migrate:rollback', ['--database' => 'testbench'])
        );
    }
}

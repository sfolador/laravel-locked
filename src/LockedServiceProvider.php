<?php

namespace Sfolador\Locked;

use Sfolador\Locked\Commands\LockedCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LockedServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-locked')
            ->hasConfigFile()
            ->hasCommand(LockedCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->singleton(Locked::class, function () {
            return new Locked();
        });

        $this->app->alias(Locked::class, 'locked');

        $this->registerProviders();
    }

    private function registerProviders()
    {
        $this->app->register(LockedEventServiceProvider::class);
    }
}

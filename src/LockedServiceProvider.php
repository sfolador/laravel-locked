<?php

namespace Sfolador\Locked;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sfolador\Locked\Commands\LockedCommand;

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
            ->hasViews()
            ->hasCommand(LockedCommand::class);
    }
}

<?php

namespace JeffersonGoncalves\LgpdRetention;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdRetentionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-lgpd-retention')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}

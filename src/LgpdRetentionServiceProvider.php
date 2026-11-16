<?php

namespace JeffersonGoncalves\LgpdRetention;

use JeffersonGoncalves\LgpdRetention\Commands\ReapplyCommand;
use JeffersonGoncalves\LgpdRetention\Commands\RetentionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdRetentionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lgpd-retention')
            ->hasConfigFile()
            ->hasMigrations(['create_lgpd_retention_tombstones_table'])
            ->hasCommands([RetentionCommand::class, ReapplyCommand::class]);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(RetentionManager::class);
    }
}

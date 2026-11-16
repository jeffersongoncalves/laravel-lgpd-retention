<?php

namespace JeffersonGoncalves\LgpdRetention;

use Illuminate\Support\Facades\Event;
use JeffersonGoncalves\Lgpd\Events\PersonalDataAnonymized;
use JeffersonGoncalves\LgpdRetention\Commands\ReapplyCommand;
use JeffersonGoncalves\LgpdRetention\Commands\RetentionCommand;
use JeffersonGoncalves\LgpdRetention\Listeners\RecordTombstones;
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

    public function packageBooted(): void
    {
        Event::listen(PersonalDataAnonymized::class, RecordTombstones::class);
    }
}

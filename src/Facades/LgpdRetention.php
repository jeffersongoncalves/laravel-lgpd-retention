<?php

namespace JeffersonGoncalves\LgpdRetention\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\LgpdRetention\RetentionManager;

/**
 * @method static list<array{model: class-string, column: string, retention: string, records: int}> apply(bool $dryRun = false)
 * @method static int reapply()
 *
 * @see RetentionManager
 */
class LgpdRetention extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RetentionManager::class;
    }
}

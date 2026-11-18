<?php

namespace JeffersonGoncalves\LgpdRetention\Commands;

use JeffersonGoncalves\LgpdRetention\RetentionManager;
use JeffersonGoncalves\Privacy\Retention\Commands\RetentionCommand as BaseRetentionCommand;

class RetentionCommand extends BaseRetentionCommand
{
    protected $signature = 'lgpd:retention {--dry-run : Only count the records that would be anonymized}';

    protected string $manager = RetentionManager::class;
}

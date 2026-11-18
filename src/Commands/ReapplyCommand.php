<?php

namespace JeffersonGoncalves\LgpdRetention\Commands;

use JeffersonGoncalves\LgpdRetention\RetentionManager;
use JeffersonGoncalves\Privacy\Retention\Commands\ReapplyCommand as BaseReapplyCommand;

class ReapplyCommand extends BaseReapplyCommand
{
    protected $signature = 'lgpd:retention-reapply';

    protected string $manager = RetentionManager::class;
}

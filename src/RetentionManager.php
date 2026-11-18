<?php

namespace JeffersonGoncalves\LgpdRetention;

use JeffersonGoncalves\Lgpd\Lgpd;
use JeffersonGoncalves\LgpdRetention\Models\Tombstone;
use JeffersonGoncalves\Privacy\Retention\RetentionManager as BaseRetentionManager;

/**
 * Anonymizes personal data whose retention period has ended, tombstones every anonymization of the suite and
 * re-applies them after a backup restore.
 */
class RetentionManager extends BaseRetentionManager
{
    protected string $config = 'lgpd-retention';

    protected string $tombstone = Tombstone::class;

    public function __construct(Lgpd $lgpd)
    {
        parent::__construct($lgpd);
    }
}

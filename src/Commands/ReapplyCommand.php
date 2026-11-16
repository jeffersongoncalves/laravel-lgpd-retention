<?php

namespace JeffersonGoncalves\LgpdRetention\Commands;

use Illuminate\Console\Command;
use JeffersonGoncalves\LgpdRetention\RetentionManager;

class ReapplyCommand extends Command
{
    protected $signature = 'lgpd:retention-reapply';

    protected $description = 'Re-anonymize tombstoned personal data that came back, e.g. after restoring a backup';

    public function handle(RetentionManager $retention): int
    {
        $this->info($retention->reapply().' column(s) re-anonymized.');

        return self::SUCCESS;
    }
}

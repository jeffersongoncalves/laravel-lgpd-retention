<?php

namespace JeffersonGoncalves\LgpdRetention\Listeners;

use JeffersonGoncalves\Lgpd\Events\PersonalDataAnonymized;
use JeffersonGoncalves\LgpdRetention\RetentionManager;

/**
 * Tombstones any anonymization (DSAR erasure, consent records...), so lgpd:retention-reapply covers it too.
 */
class RecordTombstones
{
    public function __construct(protected RetentionManager $retention) {}

    public function handle(PersonalDataAnonymized $event): void
    {
        $this->retention->tombstone($event->model, $event->columns);
    }
}

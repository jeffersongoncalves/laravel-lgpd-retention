<?php

namespace JeffersonGoncalves\LgpdRetention\Models;

use JeffersonGoncalves\Privacy\Retention\Tombstone as BaseTombstone;

class Tombstone extends BaseTombstone
{
    public function getTable(): string
    {
        return config('lgpd-retention.table', 'lgpd_retention_tombstones');
    }
}

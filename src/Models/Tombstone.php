<?php

namespace JeffersonGoncalves\LgpdRetention\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $model_type
 * @property string $model_id
 * @property string $column
 * @property string $fingerprint
 */
class Tombstone extends Model
{
    public const UPDATED_AT = null;

    protected $guarded = [];

    public function getTable(): string
    {
        return config('lgpd-retention.table', 'lgpd_retention_tombstones');
    }
}

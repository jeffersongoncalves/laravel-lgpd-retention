<?php

namespace JeffersonGoncalves\LgpdRetention\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Lgpd\Attributes\PersonalData;
use JeffersonGoncalves\Lgpd\Concerns\InteractsWithPersonalData;
use JeffersonGoncalves\Lgpd\Contracts\HasPersonalData;
use JeffersonGoncalves\LgpdRetention\Contracts\HasRetentionStart;

#[PersonalData('signer', retention: '1 year')]
class Contract extends Model implements HasPersonalData, HasRetentionStart
{
    use InteractsWithPersonalData;

    protected $guarded = [];

    public $timestamps = false;

    public static function retentionStartColumn(): string
    {
        return 'ended_at';
    }
}

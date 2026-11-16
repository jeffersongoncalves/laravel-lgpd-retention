<?php

namespace JeffersonGoncalves\LgpdRetention\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\LgpdRetention\LgpdRetention
 */
class LgpdRetention extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-lgpd-retention';
    }
}

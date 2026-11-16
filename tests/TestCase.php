<?php

namespace JeffersonGoncalves\LgpdRetention\Tests;

use JeffersonGoncalves\LgpdRetention\LgpdRetentionServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LgpdRetentionServiceProvider::class,
        ];
    }
}

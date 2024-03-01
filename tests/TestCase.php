<?php

namespace Proshore\NepaliDate\Tests;

use Proshore\NepaliDate\Facades\NepaliDateConverter;
use Proshore\NepaliDate\NepaliDateConverterServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {

        return [NepaliDateConverterServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'NepaliDateConverter' => NepaliDateConverter::class,
        ];
    }
}

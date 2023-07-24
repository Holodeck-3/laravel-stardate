<?php

namespace Holodeck3\Stardate\Tests;

use Holodeck3\Stardate\StardateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            StardateServiceProvider::class,
        ];
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }
}
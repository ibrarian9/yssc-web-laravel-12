<?php

namespace Tests;

use App\Models\HeroSection;
use App\Models\Profile;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        if ($database !== 'yssc_web_testing') {
            throw new \RuntimeException("Unsafe test database detected: {$database}. Expected yssc_web_testing.");
        }

        Profile::clearCache();
        HeroSection::clearCache();
    }
}

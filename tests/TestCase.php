<?php

namespace UpdatedData\LaravelRequestLogger\Tests;

use Illuminate\Support\Facades\Artisan;
use UpdatedData\LaravelRequestLogger\RequestLoggerServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\BrowserKit\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }

    protected function getPackageProviders($app): array
    {
        return [
            RequestLoggerServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => '/tmp/db.sqlite',
            'prefix' => '',
        ]);
    }
}
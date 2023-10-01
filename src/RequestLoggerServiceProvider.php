<?php

namespace UpdatedData\LaravelRequestLogger;

use Illuminate\Auth\AuthManager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use UpdatedData\LaravelRequestLogger\Exception\RequestLoggerException;
use UpdatedData\LaravelRequestLogger\Housekeeping\DeleteOldLogs;
use UpdatedData\LaravelRequestLogger\Logger\Compression\Compressor;
use UpdatedData\LaravelRequestLogger\Logger\Compression\NullCompressor;
use UpdatedData\LaravelRequestLogger\Logger\Compression\GzCompressor;
use UpdatedData\LaravelRequestLogger\Logger\DatabaseRequestLogger;
use UpdatedData\LaravelRequestLogger\Logger\RequestLogger;
use UpdatedData\LaravelRequestLogger\Middleware\LogRequest;

class RequestLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = __DIR__ . '/../config/request-logger.php';
        $this->mergeConfigFrom($configPath, 'request-logger');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function boot(): void
    {
        $configPath = __DIR__ . '/../config/request-logger.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
        $this->registerCompressor();
        $this->registerRequestLogger();
        $this->registerMiddleware(LogRequest::class);
        $this->registerHousekeeping();
    }

    protected function registerHousekeeping(): void
    {
        $this->app->booted(function() {
            /** @var Schedule $schedule */
            $schedule = $this->app->get(Schedule::class);
            $schedule->job(DeleteOldLogs::class)->daily();
        });
    }

    protected function getConfigPath(): string
    {
        return config_path('request-logger.php');
    }

    protected function registerMiddleware($middleware): void
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }

    protected function registerRequestLogger(): void
    {
        $this->app->singleton(RequestLogger::class, function() {
            $driverType = RequestLoggerDriverTypes::tryFrom(config('request-logger.driver'));
            return match($driverType) {
                RequestLoggerDriverTypes::DATABASE => new DatabaseRequestLogger($this->app->get(AuthManager::class), $this->app->get(Compressor::class)),
                default => throw new RequestLoggerException('No valid driver found'),
            };
        });
    }
    protected function registerCompressor(): void
    {
        $this->app->singleton(Compressor::class, function() {
            $driverType = RequestLoggerCompressorTypes::tryFrom(config('request-logger.storage.compression.compressor'));
            return match($driverType) {
                RequestLoggerCompressorTypes::GZ => new GzCompressor(),
                default => new NullCompressor(),
            };
        });
    }
}
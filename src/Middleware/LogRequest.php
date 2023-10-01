<?php

namespace UpdatedData\LaravelRequestLogger\Middleware;

use Illuminate\Http\Request;
use UpdatedData\LaravelRequestLogger\Logger\RequestLogger;

class LogRequest
{
    public function __construct(protected RequestLogger $requestLogger)
    {
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if (config('request-logger.enabled')) {
            $this->requestLogger->log($request);
        }

        return $next($request);
    }
}
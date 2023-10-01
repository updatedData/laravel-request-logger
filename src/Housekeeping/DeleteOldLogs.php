<?php

namespace UpdatedData\LaravelRequestLogger\Housekeeping;

use UpdatedData\LaravelRequestLogger\Models\RequestLog;

class DeleteOldLogs
{
    public function handle(): void
    {
        $retention = config('request-logger.storage.retention');
        if (!$retention) {
            return;
        }
        $purgeDate = now()->subDays($retention);
        RequestLog::where('created_at', '<=', $purgeDate)->each(function (RequestLog $requestLog) {
            $requestLog->delete();
        });
    }
}
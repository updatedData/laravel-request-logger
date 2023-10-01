<?php

namespace UpdatedData\LaravelRequestLogger\Housekeeping;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;

class DeleteOldLogs implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

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
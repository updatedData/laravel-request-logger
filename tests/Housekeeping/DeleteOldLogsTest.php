<?php

namespace UpdatedData\LaravelRequestLogger\Tests\Housekeeping;

use Illuminate\Support\Facades\Config;
use UpdatedData\LaravelRequestLogger\Housekeeping\DeleteOldLogs;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;
use UpdatedData\LaravelRequestLogger\Tests\TestCase;

class DeleteOldLogsTest extends TestCase
{
    public function testHandle(): void
    {
        $logs = RequestLog::factory(5)->create([
            'created_at' => now()->subDay(),
        ]);
        $this->assertEquals(5, RequestLog::all()->count());
        $first = $logs->first();
        $first->created_at = now()->addDay();
        $first->save();
        Config::set('request-logger.storage.retention', 1);
        $deleteOldLogs = new DeleteOldLogs();
        $deleteOldLogs->handle();
        $this->assertEquals(1, RequestLog::all()->count());
    }
}

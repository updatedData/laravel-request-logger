<?php

namespace UpdatedData\LaravelRequestLogger\Tests\Housekeeping;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use UpdatedData\LaravelRequestLogger\Housekeeping\DeleteOldLogs;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;
use UpdatedData\LaravelRequestLogger\Tests\TestCase;

class DeleteOldLogsTest extends TestCase
{
    public function testHandle(): void
    {
        Queue::fake();
        $logs = RequestLog::factory(5)->create([
            'created_at' => now()->subDay(),
        ]);
        $this->assertEquals(5, RequestLog::all()->count());
        $first = $logs->first();
        $first->created_at = now()->addDay();
        $first->save();
        Config::set('request-logger.storage.retention', 1);
        dispatch(new DeleteOldLogs());
        Queue::assertPushed(DeleteOldLogs::class);
        $this->assertEquals(1, RequestLog::all()->count());
    }
}

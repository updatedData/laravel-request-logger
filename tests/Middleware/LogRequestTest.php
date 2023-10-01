<?php

namespace UpdatedData\LaravelRequestLogger\Tests\Middleware;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use UpdatedData\LaravelRequestLogger\Logger\Compression\Compressor;
use UpdatedData\LaravelRequestLogger\Logger\Compression\NullCompressor;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;
use UpdatedData\LaravelRequestLogger\Tests\TestCase;

class LogRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(Compressor::class, NullCompressor::class);
    }

    public static function methodProvider(): \Generator
    {
        yield 'GET' => ['get'];
        yield 'POST' => ['post', ['key' => 'this is a post']];
        yield 'PUT' => ['put', ['key' => 'this is a put']];
        yield 'DELETE' => ['delete'];
    }


    /** @dataProvider methodProvider */
    public function testHttpMethods(string $method, ?array $body = []): void
    {
        if ($body) {
            $this->{$method}('/', $body);
        } else {
            $this->{$method}('/');
        }
        $logs = RequestLog::all();

        $this->assertCount(1, $logs);
        $log = $logs->first();
        $this->assertEqualsIgnoringCase($method, $log->method);
        $this->assertIsArray($log->header);
        $this->assertEquals($body, $log->content);
    }


    public function testShouldNotLogFiles(): void
    {
        Config::set('request-logger.storage.store_attachments', false);
        $content = 'TestUpload';
        $this->post('/', ['f' => UploadedFile::fake()->createWithContent('a.txt', $content)]);
        $logs = RequestLog::all();
        $log = $logs->first();

        $this->assertEquals(0, $log->attachments()->count());
    }

    public function testFileUpload(): void
    {
        Config::set('request-logger.storage.store_attachments', true);
        $this->post('/', ['f' => UploadedFile::fake()->createWithContent('a.txt', 'test')]);
        $logs = RequestLog::all();
        $log = $logs->first();
        $attachment = $log->attachments()->first();
        $this->assertEquals($log->id, $attachment->log_id);
        $this->assertEquals('a.txt', $attachment->name);
        $this->assertEquals('text/plain', $attachment->mime);
        $this->assertEquals('test', $attachment->data);
    }
}
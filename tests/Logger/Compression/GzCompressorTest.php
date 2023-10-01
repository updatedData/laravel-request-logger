<?php

namespace UpdatedData\LaravelRequestLogger\Tests\Logger\Compression;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use UpdatedData\LaravelRequestLogger\Logger\Compression\Compressor;
use UpdatedData\LaravelRequestLogger\Logger\Compression\GzCompressor;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;
use UpdatedData\LaravelRequestLogger\Tests\TestCase;

class GzCompressorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Config::set('request-logger.storage.store_attachments', true);
        Config::set('request-logger.storage.compression.enabled', true);
        $this->app->bind(Compressor::class, GzCompressor::class);
    }

    public function testFileUploadWithCompressionAndMultipleFiles(): void
    {
        $content = 'TestUpload';
        $this->post('/', [
            'a' => UploadedFile::fake()->createWithContent('a.txt', 'Content of a'),
            'b' => UploadedFile::fake()->createWithContent('b.txt', 'Content of b'),
        ]);
        $logs = RequestLog::all();
        $log = $logs->first();
        
        $attachments = $log->attachments;
        
        $this->assertCount(2, $attachments);
        
        $this->assertEquals('Content of a', gzuncompress($attachments[0]->data));
        $this->assertEquals('Content of b', gzuncompress($attachments[1]->data));
        
        
    }
}
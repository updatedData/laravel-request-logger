<?php

namespace UpdatedData\LaravelRequestLogger\Logger\Compression;

use Illuminate\Http\UploadedFile;

trait CompressesFile
{
    protected function compress(UploadedFile $file): string
    {
        if (config('request-logger.storage.compression.enabled')) {
            return $this->compressor->compress($file);
        }
        
        return $file->getContent();
    }
}

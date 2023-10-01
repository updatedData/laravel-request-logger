<?php

namespace UpdatedData\LaravelRequestLogger\Logger\Compression;

use Illuminate\Http\UploadedFile;

class NullCompressor implements Compressor
{
    public function compress(UploadedFile $file): string
    {
        return $file->getContent();
    }
}
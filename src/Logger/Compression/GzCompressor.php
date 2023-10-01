<?php

namespace UpdatedData\LaravelRequestLogger\Logger\Compression;

use Illuminate\Http\UploadedFile;
use UpdatedData\LaravelRequestLogger\Exception\CompressionException;

class GzCompressor implements Compressor
{
    public function compress(UploadedFile $file): string
    {
        if(!extension_loaded('zlib')) {
            throw new CompressionException('Gz compression requires the zlib extension');
        }
        
        return gzcompress($file->getContent(), 9);
    }
}
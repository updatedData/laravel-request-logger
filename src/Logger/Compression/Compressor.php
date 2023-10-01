<?php

namespace UpdatedData\LaravelRequestLogger\Logger\Compression;

use Illuminate\Http\UploadedFile;
use UpdatedData\LaravelRequestLogger\Exception\RequestLoggerException;

interface Compressor
{
    /** 
     * @throws RequestLoggerException 
     */
    public function compress(UploadedFile $file): string;
}
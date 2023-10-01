<?php

namespace UpdatedData\LaravelRequestLogger\Models;

use Illuminate\Http\UploadedFile;

trait CreatesRequestLogAttachment
{
    protected function createAttachment(RequestLog $log, UploadedFile $file): RequestLogAttachment
    {
        $attachment = new RequestLogAttachment();
        $attachment->mime = $file->getMimeType();
        $attachment->name = $file->getClientOriginalName();
        if (method_exists($this, 'compress')) {
            $attachment->data = $this->compress($file);
        } else {
            $attachment->data = $file->getContent();
        }
        $attachment->requestLog()->associate($log);
        $attachment->save();
        return $attachment;
    }
}
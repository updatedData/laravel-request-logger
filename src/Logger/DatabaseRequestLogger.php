<?php

namespace UpdatedData\LaravelRequestLogger\Logger;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use UpdatedData\LaravelRequestLogger\Logger\Compression\Compressor;
use UpdatedData\LaravelRequestLogger\Logger\Compression\CompressesFile;
use UpdatedData\LaravelRequestLogger\Logger\Filter\FiltersRequestContent;
use UpdatedData\LaravelRequestLogger\Models\CreatesRequestLogAttachment;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;

class DatabaseRequestLogger implements RequestLogger
{
    use CompressesFile;
    use CreatesRequestLogAttachment;
    use FiltersRequestContent;
    
    public function __construct(protected AuthManager $authManager, protected readonly Compressor $compressor)
    {
    }

    public function log(Request $request): void
    {
        $logEntry = new RequestLog();
        if($user = $this->authManager->user()) {
            $logEntry->user_id = $user->getKey();
        }
        $logEntry->url = $request->url();
        $logEntry->header = $request->header();
        
        [$content, $files] = $this->filterRequestContent($request);
        
        $logEntry->content = $content;
        $logEntry->method = $request->getMethod();

        $logEntry->save();
        
        if (config('request-logger.storage.store_attachments') && count($files) > 0) {
            foreach($files as $file) {
                $this->createAttachment($logEntry, $file);
            }
        }
    }
}
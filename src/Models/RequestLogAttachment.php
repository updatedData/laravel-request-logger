<?php

namespace UpdatedData\LaravelRequestLogger\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $log_id
 * @property string $name
 * @property string $mime
 * @property string $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read RequestLog $requestLog
 */
class RequestLogAttachment extends Model
{
    public $table = 'request_log_attachments';

    public function requestLog(): BelongsTo
    {
        return $this->belongsTo(RequestLog::class, 'log_id', 'id', 'requestLog');
    }
}
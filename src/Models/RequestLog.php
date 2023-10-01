<?php

namespace UpdatedData\LaravelRequestLogger\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property string|null $user_id
 * @property string $url
 * @property string $method
 * @property array $header
 * @property array $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read RequestLogAttachment[]|Collection $attachments
 */
class RequestLog extends Model
{
    use HasFactory;
    
    public $table = 'request_logs';

    public $casts = [
        'header' => 'array',
        'content' => 'array',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::saving(function (Model $model) {
            $model->ulid = Str::orderedUuid();
        });
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(RequestLogAttachment::class, 'log_id', 'id');
    }
}
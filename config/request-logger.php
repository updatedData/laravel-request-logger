<?php

return [
    'enabled' => env('REQUEST_LOGGER_ENABLED', true),
    'driver' => env('REQUEST_LOGGER_DRIVER', 'database'),
    'storage' => [
        'retention' => (int)env('REQUEST_LOGGER_RETENTION', 14),
        'store_attachments' => (bool)env('REQUEST_LOGGER_STORE_ATTACHMENTS', false),
        'compression' => [
            'enabled' => (bool)env('REQUEST_LOGGER_COMPRESSION_ENABLED', false),
            'compressor' => (bool)env('REQUEST_LOGGER_COMPRESSION_COMPRESSOR', 'gz'),
        ]
    ],
];
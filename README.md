## Requestlogger for Laravel

This package logs all http-Request. It also optionally saves attached files and also optionally compresses them.

### Installation:

- Require the package
```shell
composer require updateddata/laravel-request-logger
```
- Publish the assets
```shell
php artisan vendor:publish --provider="UpdatedData\LaravelRequestLogger\RequestLoggerServiceProvider"
```

### Config:

All variables can either be set as ENV vars or in ``config/request-logger.php``

| Name | Default  | Effect                                                             |
|------|----------|--------------------------------------------------------------------|
| REQUEST_LOGGER_ENABLED | true     | Enables or disables logging                                        |
|  REQUEST_LOGGER_DRIVER | database | Defines how the logging should be done                             |
|   REQUEST_LOGGER_RETENTION   | 14       | Defines how long the logs should be kept. Set to 0 for indefinetly |
|    REQUEST_LOGGER_STORE_ATTACHMENTS  | false    | Enables persistence for uploaded files                             |
|   REQUEST_LOGGER_COMPRESSION_ENABLED   | false    | Enables compression for uploaded files.                            |
|  REQUEST_LOGGER_COMPRESSION_COMPRESSOR    | gz       | Compressionalgorith. For now only gz is supported                  |


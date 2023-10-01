<?php

namespace UpdatedData\LaravelRequestLogger;

enum RequestLoggerDriverTypes:string
{
    case DATABASE = 'database';
    case FILE = 'file';
}
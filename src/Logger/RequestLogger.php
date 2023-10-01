<?php

namespace UpdatedData\LaravelRequestLogger\Logger;

use Illuminate\Http\Request;

interface RequestLogger
{
    public function log(Request $request): void;
    
}

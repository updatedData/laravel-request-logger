<?php

namespace UpdatedData\LaravelRequestLogger\Logger\Filter;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

trait FiltersRequestContent
{
    public function filterRequestContent(Request $request): array
    {
        $content = [];
        $files = [];
        foreach ($request->all() as $key => $value) {
            if ($value instanceof UploadedFile) {
                $files[$key] = $value;
            } else {
                $content[$key] = $value;
            }
        }

        return [$content, array_merge($files, $request->files->all())];
    }
}
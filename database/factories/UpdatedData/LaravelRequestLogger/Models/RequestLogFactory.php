<?php

namespace Database\Factories\UpdatedData\LaravelRequestLogger\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use UpdatedData\LaravelRequestLogger\Models\RequestLog;

class RequestLogFactory extends Factory
{
    protected $model = RequestLog::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url,
            'method' => 'GET',
            'header' => 'testing',
        ];
    }
}
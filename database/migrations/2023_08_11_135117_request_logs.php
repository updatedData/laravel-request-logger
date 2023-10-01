<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_logs', function(Blueprint $table) {
            $table->id();
            $table->ulid()->unique();
            $table->string('user_id')->nullable();
            $table->string('url');
            $table->string('method');
            $table->json('header');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('request_logs');
    }
};

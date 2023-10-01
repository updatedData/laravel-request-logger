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
        Schema::create('request_log_attachments', static function(Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('log_id');
            $t->string('name');
            $t->string('mime')->nullable();
            $t->binary('data');
            $t->timestamps();
        });
        
        Schema::table('request_log_attachments',  static function(Blueprint $t) {
            $t->foreign('log_id')
                ->references('id')
                ->on('request_logs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('request_log_attachments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('video_url')->nullable()->change(); // Modify video_url to be nullable
        });
    }
    
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('video_url')->nullable(false)->change(); // Rollback to the non-nullable state if needed
        });
    }
    
};

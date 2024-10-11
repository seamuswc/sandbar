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

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('price');
            $table->decimal('size', 10, 2);
            $table->decimal('lat', 19, 15);
            $table->decimal('lng', 19, 15);
            $table->string('building');
            $table->string('video_url');
            $table->text('description'); 
            $table->timestamps();
        });

    }

    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

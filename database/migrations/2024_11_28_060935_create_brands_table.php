<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; // Add this line

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('serial_number')->unique();
            $table->timestamps();
        });

        // Add logging to check if the brands parameter is being received correctly
        Log::info('Selected Brands:', request()->input('brands'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};

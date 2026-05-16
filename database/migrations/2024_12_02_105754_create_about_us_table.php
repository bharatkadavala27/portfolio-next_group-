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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            // About Us Section
            $table->string('about_us_image_1')->nullable();
            $table->string('about_us_title_1')->nullable();
            $table->text('about_us_description_1')->nullable();

            $table->string('about_us_image_2')->nullable();
            $table->string('about_us_title_2')->nullable();
            $table->text('about_us_description_2')->nullable();

            $table->string('about_us_image_3')->nullable();
            $table->string('about_us_title_3')->nullable();
            $table->text('about_us_description_3')->nullable();

            // Another Section
            $table->string('mission_image')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();

            $table->string('vision_image')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();

            $table->string('goals_image')->nullable();
            $table->string('goals_title')->nullable();
            $table->text('goals_description')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};

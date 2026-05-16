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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique(); // Unique serial number
            $table->string('name'); // Name of the category
            $table->string('slug'); // URL-friendly name
            $table->longText('description'); // Detailed description
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent category ID
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade'); // Foreign key relationship

            $table->string('image')->nullable(); // Optional image field
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories'); // Drops the 'categories' table if it exists.
    }

};

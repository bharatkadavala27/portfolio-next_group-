<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();  // Auto-increment primary key
            $table->string('name')->unique(); // Unique category name
            $table->string('slug')->unique(); // Unique slug for SEO-friendly URLs
            $table->text('description')->nullable(); // Category description (optional)
            $table->unsignedBigInteger('serial_number')->unique()->nullable(); // Unique serial number
            $table->string('image')->nullable(); // Category image (optional)
            $table->unsignedBigInteger('parent_id')->nullable(); // Self-referencing parent category
            $table->timestamps(); // Created_at & Updated_at

            // Foreign key for parent_id (Self-Join)
            $table->foreign('parent_id')->references('id')->on('document_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_categories');
    }
};

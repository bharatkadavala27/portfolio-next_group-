<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->integer('subcategory_ids')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');

            // Store a single image
            // $table->string('image')->nullable();

            // Store multiple images (JSON format)
            $table->json('images')->nullable(); // To store image URLs or paths
            $table->text('description')->nullable();
            $table->string('serial_number')->unique()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
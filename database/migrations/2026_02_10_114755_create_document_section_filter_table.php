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
        Schema::create('document_section_filter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents_sections')->onDelete('cascade');
            $table->foreignId('filter_option_id')->constrained('filter_options')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_section_filter');
    }
};

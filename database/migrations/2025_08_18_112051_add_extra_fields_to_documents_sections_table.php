<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::table('documents_sections', function (Blueprint $table) {
            $table->string('file_link')->nullable()->after('documents'); 
            $table->string('language')->nullable()->after('file_link'); 
            $table->date('version_date')->nullable()->after('language'); 
            $table->string('version')->nullable()->after('version_date'); 
            $table->string('size')->nullable()->after('version'); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents_sections', function (Blueprint $table) {
        });
    }
};

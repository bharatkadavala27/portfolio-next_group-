<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name')->unique(); // Document Type Name
            $table->text('description')->nullable(); // Description
            $table->string('image')->nullable(); // Image
            $table->integer('serial_number')->unique(); // Serial Number
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_types');
    }
};
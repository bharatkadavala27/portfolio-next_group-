<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('document_categories')) {
            Schema::create('document_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->integer('serial_number')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable(); // For parent category
                $table->string('image')->nullable();
                $table->timestamps();

                // Foreign key to reference parent category
                $table->foreign('parent_id')->references('id')->on('document_categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_categories');
    }
}

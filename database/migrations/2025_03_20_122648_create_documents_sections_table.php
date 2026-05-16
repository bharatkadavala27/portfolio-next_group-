<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('documents_sections')) {
            Schema::create('documents_sections', function (Blueprint $table) {
                $table->id();
                $table->string('document_name');
                $table->string('document_type');
                $table->string('document_category');
                $table->string('document_brand');
                $table->text('description')->nullable();
                $table->string('file_path');
                $table->string('document_file'); // Required field for document file
                $table->string('documents');
                $table->timestamps();
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
        if (Schema::hasTable('documents_sections')) {
            Schema::dropIfExists('documents_sections');
        }
    }
}

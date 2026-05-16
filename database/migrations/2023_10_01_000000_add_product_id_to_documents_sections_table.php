<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToDocumentsSectionsTable extends Migration
{
    public function up()
    {
        Schema::table('documents_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('documents'); // Add product_id column
        });
    }

    public function down()
    {
        Schema::table('documents_sections', function (Blueprint $table) {
            $table->dropColumn('product_id'); // Rollback column
        });
    }
}

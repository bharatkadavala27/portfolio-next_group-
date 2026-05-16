<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDescriptionColumnInCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });
    }
}

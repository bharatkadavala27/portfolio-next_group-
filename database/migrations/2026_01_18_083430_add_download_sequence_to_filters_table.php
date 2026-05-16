<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('filters', 'download_sequence')) {
            Schema::table('filters', function (Blueprint $table) {
                $table->integer('download_sequence')->nullable()->default(0)->after('sequence');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('filters', 'download_sequence')) {
            Schema::table('filters', function (Blueprint $table) {
                $table->dropColumn('download_sequence');
            });
        }
    }
};

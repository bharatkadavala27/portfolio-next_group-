<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'Subcategories' system filter
        DB::table('filters')->updateOrInsert(
            ['key' => 'subcategory_system'],
            [
                'name' => 'Subcategories',
                'type' => 'system',
                'sequence' => 10,
                'updated_at' => now(),
            ]
        );

        // Add 'Document Type' system filter
        DB::table('filters')->updateOrInsert(
            ['key' => 'document_type_system'],
            [
                'name' => 'Document Type',
                'type' => 'system',
                'sequence' => 1,
                'updated_at' => now(),
            ]
        );

        // Add 'Brand' system filter
        DB::table('filters')->updateOrInsert(
            ['key' => 'brand_system'],
            [
                'name' => 'Brand',
                'type' => 'system',
                'sequence' => 2,
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally delete them, but usually better to leave data unless strictly rolling back structure
    }
};

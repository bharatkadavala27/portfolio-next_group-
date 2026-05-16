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
        Schema::table('filters', function (Blueprint $table) {
            $table->integer('sequence')->default(0)->after('type'); // Add sequence column
            $table->string('key')->nullable()->unique()->after('sequence'); // Add key column for system filters
        });

        // Seed System Filters
        DB::table('filters')->insert([
            [
                'name' => 'Categories',
                'type' => 'both', // Or 'product' - depends on usage, 'both' is safest for general visibility
                'sequence' => 1,
                'key' => 'category_system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brands',
                'type' => 'both',
                'sequence' => 2,
                'key' => 'brand_system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove seeded data first if needed (optional but good for cleanup)
        DB::table('filters')->whereIn('key', ['category_system', 'brand_system'])->delete();

        Schema::table('filters', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->dropColumn('key');
        });
    }
};

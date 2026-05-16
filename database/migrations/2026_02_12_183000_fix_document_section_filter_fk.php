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
        if (Schema::hasTable('document_section_filter')) {
            Schema::table('document_section_filter', function (Blueprint $table) {
                // Check if the specific incorrect foreign key exists manually to be safe
                // or just attempt to drop it if we rely on the user report.
                // Using raw SQL to be robust against "foreign key does not exist" errors in some drivers if using dropForeign directly without check.

                // However, Laravel's dropForeign usually keeps going? No, it throws.
                // Let's rely on a try-catch block for the drop, or just simple logic if we trust the custom name.
                // Given the explicit error "CONSTRAINT fk_dsf_document", we target that.

                $fkName = 'fk_dsf_document';

                // We'll check if it exists first to avoid migration failure if re-run or already fixed
                $constraintExists = DB::table('information_schema.table_constraints')
                    ->where('constraint_schema', DB::raw('DATABASE()'))
                    ->where('table_name', 'document_section_filter')
                    ->where('constraint_name', $fkName)
                    ->exists();

                if ($constraintExists) {
                    $table->dropForeign($fkName);
                }

                // Also checking for the standard one if it points to the wrong table is harder without introspection.
                // We will assume that if fk_dsf_document existed, it was the problem.

                // Now add the correct relationship
                // We first check if the correct foreign key already exists to avoid duplication error (though standard names are deduped usually)
                // We will rely on establishing the new foreign key.

                // Note: We need to make sure we don't have TWO foreign keys on the same column.
                // If there was another one, we might need to drop it too?
                // For now, let's proceed with adding the correct one.

                $table->foreign('document_id', 'dsf_document_id_correct') // Custom name to ensure uniqueness/clarity
                    ->references('id')
                    ->on('documents_sections')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('document_section_filter')) {
            Schema::table('document_section_filter', function (Blueprint $table) {
                $table->dropForeign('dsf_document_id_correct');

                // Optionally restore the old broken one? probably not.
                // But for completeness of "down":
                // $table->foreign('document_id', 'fk_dsf_document')->references('id')->on('documents')->onDelete('cascade');
            });
        }
    }
};

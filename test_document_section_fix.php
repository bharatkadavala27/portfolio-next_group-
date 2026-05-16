<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DocumentsSection;
use App\Models\DocumentType;
use App\Models\DocumentCategory;
use App\Models\DocumentBrand;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Support\Facades\Log;

// Ensure we have necessary data
$type = DocumentType::firstOrCreate(
    ['name' => 'Test Type'],
    ['serial_number' => rand(1000, 9999), 'image' => 'default.png', 'description' => 'Test Description']
);
$category = DocumentCategory::firstOrCreate(
    ['name' => 'Test Category'],
    ['slug' => 'test-category', 'serial_number' => rand(1000, 9999), 'image' => 'default.png', 'description' => 'Test Description']
);
$brand = DocumentBrand::firstOrCreate(
    ['name' => 'Test Brand'],
    ['serial_number' => rand(1000, 9999), 'image' => 'default.png', 'description' => 'Test Description']
);

// Create a test filter and option
$filter = Filter::firstOrCreate(
    ['name' => 'Test Filter', 'type' => 'document'],
    ['sequence' => 1, 'key' => 'test_filter'] // Assuming these might be needed based on migration names seen earlier
);
$option = FilterOption::firstOrCreate(
    ['filter_id' => $filter->id, 'name' => 'Test Option']
);

echo "Prerequisites created/found.\n";

try {
    $document = DocumentsSection::create([
        'document_name' => 'Test Document',
        'document_type' => $type->name,
        'document_category' => $category->name,
        'document_brand' => $brand->name,
        'description' => 'Test Description',
        'file_path' => null,
        'documents' => null,
        'file_link' => 'http://example.com',
        'language' => 'English',
        'version_date' => now(),
        'version' => '1.0',
        'size' => '1MB',
    ]);

    echo "Document created: " . $document->id . "\n";

    // Sync filters
    $document->filters()->sync([$option->id]);

    echo "Filters synced successfully.\n";

    // Verify persistence
    $reloaded = DocumentsSection::with('filters')->find($document->id);
    if ($reloaded->filters->contains($option->id)) {
        echo "VERIFICATION PASSED: Filter relationship works.\n";
    } else {
        echo "VERIFICATION FAILED: Filter not attached.\n";
    }

    // Cleanup
    $document->delete();
    // $option->delete();
    // $filter->delete();

} catch (\Exception $e) {
} catch (\Throwable $e) {
    Log::error("TEST SCRIPT ERROR: " . $e->getMessage());
    echo "ERROR LOGGED";
}

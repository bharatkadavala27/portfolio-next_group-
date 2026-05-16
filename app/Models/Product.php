<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;




class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'serial_number',
        'brand_id',
        'category_id',
        'subcategory_ids',
        'short_description', // ✅ new
    ];




    protected $casts = [
        'images' => 'array',
        'subcategory_ids' => 'array',
        'short_description' => 'array' // ✅ new

    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
    public function mainDocuments()
    {
        return $this->hasMany(MainDocument::class, 'product_id');
    }

    // Relationship with documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }








    /**
     * Resolve a stored image value to a public URL.
     * Tries: uploads/products, Uploads/products, uploads, Uploads and url-encoded variants.
     * Returns an asset() URL or the original full URL if stored value is a URL.
     *
     * @param string $storedImage
     * @return string
     */
    public function resolveImageUrl(string $storedImage): string
    {
        // If it's already a full URL, return it directly
        if (Str::startsWith($storedImage, ['http://', 'https://', '//'])) {
            return $storedImage;
        }

        // Normalize: remove common prefixes and leading slashes
        $base = preg_replace(
            '#^(uploads/products/|Uploads/products/|uploads/|Uploads/|/uploads/products/|/Uploads/products/|/uploads/|/Uploads/)#i',
            '',
            $storedImage
        );
        $base = ltrim($base, '/');

        // Try common candidate relative paths (relative to public/)
        $candidates = [
            'uploads/products/' . $base,
            'Uploads/products/' . $base,
            'uploads/' . $base,
            'Uploads/' . $base,
            // fallback variants some systems may have used
            'public/uploads/products/' . $base,
            'public/uploads/' . $base,
        ];

        // Also try URL-encoded filename (spaces -> %20)
        $encoded = str_replace(' ', '%20', $base);
        $candidates = array_merge($candidates, [
            'uploads/products/' . $encoded,
            'Uploads/products/' . $encoded,
            'uploads/' . $encoded,
            'Uploads/' . $encoded,
        ]);

        // Return first physically existing path as asset()
        foreach ($candidates as $candidate) {
            if (File::exists(public_path($candidate))) {
                return asset($candidate);
            }
        }

        // If none exists, return a sensible fallback path (so <img> won't be empty)
        return asset('uploads/products/' . $base);
    }

    /**
     * Optional helper: returns an array of resolved image URLs for the product images JSON.
     * Usage: $product->resolved_images
     *
     * @return array
     */
    public function getResolvedImagesAttribute(): array
    {
        $images = $this->images ?? [];
        if (!is_array($images)) {
            $images = json_decode($images, true) ?? [];
        }
        return array_map(fn($img) => $this->resolveImageUrl($img), $images);
    }


    public function filters()
    {
        return $this->belongsToMany(
            \App\Models\FilterOption::class,
            'product_filter',
            'product_id',
            'filter_option_id'
        )
            ->withTimestamps();
    }
}

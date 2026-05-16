<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents'; // Specify the correct table name

    protected $fillable = [
        'document_name',
        'name',
        'type',
        'category_id',
        'brand_id',
        'product_id',
        'description',
        'file_path',
        'path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'type', 'id');
    }

    public function hasFile()
    {
        return !empty($this->file_path);
    }

    public function hasLink()
    {
        return !empty($this->path);
    }

    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category', 'id');
    }

    public function documentBrand()
    {
        return $this->belongsTo(DocumentBrand::class, 'document_brand', 'id');
    }
}

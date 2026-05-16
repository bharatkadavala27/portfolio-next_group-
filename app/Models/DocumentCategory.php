<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $table = 'document_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'serial_number',
        'parent_id',
        'image'
    ];

    public function parent()
    {
        return $this->belongsTo(DocumentCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DocumentCategory::class, 'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(DocumentCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function shortAttributes()
    {
        return $this->hasMany(ShortAttribute::class);
    }
}

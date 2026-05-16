<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentBrand extends Model
{
    protected $table = 'document_brands'; // Fix table name
    protected $fillable = [
        'name',
        'image',
        'description',
        'serial_number',
    ];

    public function documentSections()
    {
        return $this->hasMany(DocumentsSection::class, 'document_brand', 'id');
    }
}

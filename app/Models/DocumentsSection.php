<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsSection extends Model
{
    use HasFactory;

    protected $table = 'documents_sections';

    protected $fillable = [
        'document_name',
        'document_type',
        'document_category',
        'document_brand',
        'description',
        'file_path',
        'documents',
        'file_link',
        'language',
        'version_date',
        'version',
        'size'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'version_date' => 'date'
    ];

    // Existing relationships
    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category', 'name');
    }

    public function documentBrand()
    {
        return $this->belongsTo(DocumentBrand::class, 'document_brand', 'name');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type', 'name');
    }

    // 🔹 New relationship for dynamic filters
    public function filters()
    {
        return $this->belongsToMany(
            \App\Models\FilterOption::class,
            'document_section_filter',    // New pivot table
            'document_id',        // FK in pivot for document section
            'filter_option_id'    // FK in pivot for filter options
        )
            ->withTimestamps();
    }




}

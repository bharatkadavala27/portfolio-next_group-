<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilterOption extends Model
{
    use HasFactory;

    protected $fillable = ['filter_id', 'name'];

    // Relation: Option belongs to a filter
    public function filter()
    {
        return $this->belongsTo(\App\Models\Filter::class);
    }


    // Relation: Option can belong to many documents (pivot table)
    public function documents()
    {
        return $this->belongsToMany(
            Document::class,
            'document_filter',
            'filter_option_id',
            'document_id'
        );
    }

    // Relation: Option can belong to many products (pivot table)
    public function products()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'product_filter',
            'filter_option_id',
            'product_id'
        );
    }

}

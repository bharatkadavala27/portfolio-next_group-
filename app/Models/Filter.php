<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'sequence', 'key', 'download_sequence'];

    // Relation: A filter has many options
    public function options()
    {
        return $this->hasMany(\App\Models\FilterOption::class, 'filter_id');
    }

    // Relation: Filter can have many documents through options
    public function documents()
    {
        return $this->hasManyThrough(
            Document::class,
            FilterOption::class,
            'filter_id',      // Foreign key on filter_options
            'id',             // Foreign key on documents (if needed)
            'id',             // Local key on filters
            'id'              // Local key on filter_options
        );
    }

}

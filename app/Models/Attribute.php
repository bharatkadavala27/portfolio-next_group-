<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shortAttributes()
    {
        return $this->hasMany(ShortAttribute::class);
    }
    public function short_attributes()
{
    return $this->hasMany(ShortAttribute::class);
}
}

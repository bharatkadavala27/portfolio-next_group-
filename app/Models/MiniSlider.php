<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MiniSlider extends Model
{
    use HasFactory;

    protected $table ='minisiders';

    protected $fillable = [
        'title',
        'description',
        'image',
        'status'
    ];
}

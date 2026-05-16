<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TwoImageSlider extends Model
{
    use HasFactory;

    protected $table = 'two_image_sliders';

    protected $fillable = [
        'title',
        'description',
        'image',
        'status'
    ];
}

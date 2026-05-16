<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SecondSlider extends Model
{
    use HasFactory;

    protected $table ='secondsliders';

    protected $fillable = [
        'title',
        'description',
        'image',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutSettings extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'about_us_title_1',
        'about_us_description_1',
        'about_us_image_1',
        'about_us_title_2',
        'about_us_description_2',
        'about_us_image_2',
        'about_us_title_3',
        'about_us_description_3',
        'about_us_image_3',
        'mission_title',
        'mission_description',
        'mission_image',
        'vision_title',
        'vision_description',
        'vision_image',
        'goals_title',
        'goals_description',
        'goals_image',
    ];
}

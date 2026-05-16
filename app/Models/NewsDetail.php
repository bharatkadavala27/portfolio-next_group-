<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class NewsDetail extends Model
{

    protected $table = 'news_details';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'news_id',
        'short_title',
        'short_image',
        'short_description',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}

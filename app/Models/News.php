<?php

namespace App\Models;

use App\Models\NewsDetail;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['header', 'image', 'description'];

    public function details()
    {
        return $this->hasMany(NewsDetail::class);
    }
}

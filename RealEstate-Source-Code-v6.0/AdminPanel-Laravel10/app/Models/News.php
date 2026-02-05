<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";
    protected $fillable = ['category_id', 'title', 'content', 'image_name'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}

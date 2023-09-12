<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;


    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());

    }
    public function scopeFeatured($query, $condition)
    {
        $query->where('featured', $condition);

    }
}

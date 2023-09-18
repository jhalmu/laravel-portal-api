<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        return view(
            'posts.index',
            [
                'tags' => Tag::whereHas('posts', function ($query) {
                    $query->published();
                })->take(10)->get()
            ]
        );
    }
}

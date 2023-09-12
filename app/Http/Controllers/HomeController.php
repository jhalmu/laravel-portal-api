<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
            return view('home', [
                'featuredPosts' => Post::published()->featured(1)->latest('published_at')->take(3)->get(),
                'latestPosts' => Post::published()->featured(0)->latest('published_at')->take(9)->get()
            ]);

    }
}

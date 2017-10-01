<?php

namespace App\Http\Controllers;

use App\Article;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {

        // Get some articles items to show
        $news = Article::with('author.group', 'editor.group')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('home')->with('articles', $news);
    }
}
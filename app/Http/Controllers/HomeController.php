<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {

        // Get some news items to show
        $news = News::with('author', 'editor')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('home')->with('news', $news);
    }
}
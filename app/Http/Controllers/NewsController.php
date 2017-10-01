<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Response;

class NewsController extends Controller
{

    public function article(Article $article)
    {
        return view('news.article')
            ->with('articles', [$article]);
    }

    /**
     * Display the archive page
     *
     * @return Response
     */
    public function archive()
    {
        // Get some articles items to show
        $months = Article::select([
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_at'),
        ])
            ->groupBy('created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('news.archive')
            ->with('months', $months);
    }

    /**
     * Display a month worth of articles
     *
     * @param int $year
     * @param int $month
     * @return \Illuminate\Http\Response
     */
    public function month($year, $month)
    {
        $date = Carbon::createFromDate($year, $month, 0);

        // Get some articles items to show
        $news = Article::with('author', 'editor')
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->where(DB::raw('YEAR(created_at)'), $year)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('news.articles')
            ->with('articles', $news)
            ->with('title', "News from " . $date->format('F Y'));
    }
}
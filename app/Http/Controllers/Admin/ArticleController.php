<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\UpdateArticle;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Auth;
use Redirect;
use Response;
use Session;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class);
    }

    /**
     * Display a listing of articles.
     *
     * @return Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('news_view')) {
            return redirect()->route('admin.home');
        }

        $articles = Article::with('author', 'editor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.articles.list')
            ->with('articles', $articles);
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('news_post')) {
            return redirect()->route('admin.home');
        }

        return view('admin.articles.create');
    }

    public function store(StoreArticle $request)
    {
        if (!Auth::user()->hasPermission('news_post')) {
            return redirect()->route('admin.home');
        }

        $article = new Article();

        $article->user_id = $request->user()->id;
        $article->title   = $request->input('title');
        $article->content = \Purifier::clean($request->input('content'));

        if ($article->save()) {
            return redirect()->route('admin.articles.edit', $article)->with('messages', [
                'News post has been created',
            ]);
        } else {
            return redirect()->route('admin.articles.create', $article)->withErrors($article->validationErrors);
        }
    }

    public function edit(Article $article)
    {
        if (!Auth::user()->hasPermission('news_edit')) {
            return redirect()->route('admin.home');
        }

        $authors = User::all();

        return view('admin.articles.edit')
            ->with('messages', Session::get('messages'))
            ->with('authors', $authors)
            ->with('article', $article);
    }

    public function update(UpdateArticle $request, Article $article)
    {
        if (!Auth::user()->hasPermission('news_edit')) {
            return redirect()->route('admin.home');
        }

        $article->title   = $request->input('title');
        $article->user_id = $request->input('author');
        $article->content = \Purifier::clean($request->input('content'));
        $article->editor()->associate(Auth::user());

        if ($article->save()) {
            return Redirect::route('admin.articles.edit', $article)->with('messages', ['News post has been updated']);
        }

        return Redirect::route('admin.articles.edit', $article)->withErrors($article->validationErrors);
    }

    public function destroy(Article $article)
    {
        if (!Auth::user()->hasPermission('news_delete')) {
            return response([
                'success' => false,
                'message' => 'You do not have permission to do that.',
            ], 403);
        }

        if (!$article->delete()) {
            return response([
                'success' => false,
                'message' => "\"{$article->title}\" could not be deleted.",
            ], 400);
        }

        return response([
            'success' => true,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\User;
use Auth;
use Redirect;
use Response;
use Session;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     *
     * @return Response
     */
    public function getIndex()
    {
        if (!Auth::user()->hasPermission('news_view')) {
            return Redirect::route('admin');
        }

        $news = News::with('author', 'editor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.news.list')
            ->with('news', $news);
    }

    public function getCreate()
    {
        if (!Auth::user()->hasPermission('news_post')) {
            return Redirect::route('admin');
        }

        return view('admin.news.create');
    }

    public function postCreate(Request $request)
    {
        if (!Auth::user()->hasPermission('news_post')) {
            return Redirect::route('admin');
        }

        $article = new News();

        $article->user_id = Auth::user()->id;
        $article->title   = $request->input('title');
        $article->content = \Purifier::clean($request->input('content'));

        if ($article->save()) {
            return Redirect::action('Admin\NewsController@getEdit', $article->id)->with('messages', ['News post has been created']);
        } else {
            return Redirect::action('Admin\NewsController@getCreate')->withErrors($article->validationErrors);
        }
    }

    public function getEdit($id)
    {
        if (!Auth::user()->hasPermission('news_edit')) {
            return Redirect::route('admin');
        }

        $article = News::find($id);
        $authors = User::all();

        return view('admin.news.edit')
            ->with('messages', Session::get('messages'))
            ->with('authors', $authors)
            ->with('article', $article);
    }

    public function postEdit(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('news_edit')) {
            return Redirect::route('admin');
        }

        $article          = News::find($id);
        $article->title   = $request->input('title');
        $article->user_id = $request->input('author');
        $article->content = \Purifier::clean($request->input('content'));
        $article->editor()->associate(Auth::user());

        if ($article->save()) {
            return Redirect::action('Admin\NewsController@getEdit', $id)->with('messages', ['News post has been updated']);
        } else {
            return Redirect::action('Admin\NewsController@getEdit', $id)->withErrors($article->validationErrors);
        }
    }

    public function postDelete($id)
    {
        $response['success'] = true;

        if (!Auth::user()->hasPermission('news_delete')) {
            $response['success'] = false;
            $response['message'] = 'You do not have permission to do that.';

            return Response::json($response);
        }

        $article = News::find($id);

        if (!$article->delete()) {
            $response['success'] = false;
            $response['message'] = "\"{$article->title}\" could not be deleted.";
        }

        return \Response::json($response);
    }
}
<?php

class NewsController extends BaseController {

	/**
	 * Display a listing of news.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$news = News::orderBy('created_at', 'desc')->get();

		return View::make('admin.news.list')
			->with('news', $news);
	}

	// ------------------------------------------------------------------------

	public function getCreate()
	{
		return View::make('admin.news.create');
	}

	// ------------------------------------------------------------------------

	public function postCreate()
	{
		$article = new News();

		$article->title   = Input::get('title');
		$article->content = Input::get('content');

		if ($article->save())
		{
			return Redirect::action('NewsController@getEdit', $article->id)->with('message', 'News post has been created');
		}
		else
		{
			return Redirect::action('NewsController@getCreate')->with('errors', $article->errors()->all());
		}
	}

	// ------------------------------------------------------------------------

	public function getEdit($id)
	{
		$article = News::find($id);

		return View::make('admin.news.edit')
			->with('article', $article);
	}

	// ------------------------------------------------------------------------

	public function postEdit($id)
	{
		$article = News::find($id);

		$article->title   = Input::get('title');
		$article->content = Input::get('content');

		if ($article->save())
		{
			return Redirect::action('NewsController@getEdit', $id)->with('message', 'News post has been updated');
		}
		else
		{
			return Redirect::action('NewsController@getEdit', $id)->with('errors', $article->errors()->all());
		}
	}

	// ------------------------------------------------------------------------

	public function postDelete($id)
	{
		$response['success'] = true;

		$article = News::find($id);

		if ( ! $article->delete())
		{
			$response['success'] = false;
			$response['message'] = "\"{$article->title}\" could not be deleted.";
		}

		return Response::json($response);
	}

}
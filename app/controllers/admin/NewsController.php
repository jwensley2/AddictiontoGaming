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
		# code...
	}

	// ------------------------------------------------------------------------

	public function postCreate()
	{
		# code...
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
			return Redirect::action('NewsController@getEdit', $id)->with('message', 'Article Saved');
		}
		else
		{
			return Redirect::action('NewsController@getEdit', $id)->with('errors', $article->errors()->all());
		}
	}

	// ------------------------------------------------------------------------

	public function postDelete($id)
	{
		# code...
	}

}
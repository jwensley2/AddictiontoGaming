<?php

class HomeController extends BaseController {

	/**
	 * Display the homepage
	 */

	public function index()
	{
		// Get some news items to show
		$news = News::with('user', 'editor')
			->orderBy('created_at', 'desc')
			->paginate(5);

		return View::make('home')->with('news', $news);
	}

}
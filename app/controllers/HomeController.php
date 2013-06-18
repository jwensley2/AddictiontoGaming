<?php

class HomeController extends BaseController {

	/**
	 * Display the homepage
	 */

	public function index()
	{
		// Get some news items to show
		$news = News::take(5)->orderBy('created_at', 'desc')->get();

		return View::make('home')->with('news', $news);
	}

}
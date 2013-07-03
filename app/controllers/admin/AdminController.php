<?php

class AdminController extends BaseController {

	/**
	 * Display the homepage
	 */

	public function index()
	{
		$news      = News::take(5)->orderBy('created_at', 'desc')->get();
		$donations = Donation::with('donor')->orderBy('created_at', 'desc')->take(5)->get();

		return View::make('admin.panel')
			->with('news', $news)
			->with('donations', $donations);
	}

}
<?php

class NewsController extends BaseController {

	/**
	 * Display the archive page
	 *
	 * @return response
	 */
	public function getArchive()
	{
		// Get some news items to show
		$months = News::select('created_at')
			->groupBy(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'))
			->orderBy('created_at', 'desc')
			->get();

		return View::make('news.archive')->with('months', $months);
	}

	/**
	 * Display a month worth of news
	 *
	 * @param int $year
	 * @param int $month
	 * @return response
	 */
	public function getMonth($year, $month)
	{
		// Get some news items to show
		$news = News::with('user', 'editor')
			->where(DB::raw('MONTH(created_at)'), $month)
			->where(DB::raw('YEAR(created_at)'), $year)
			->orderBy('created_at', 'desc')
			->get();

		return View::make('news.month')->with('news', $news);
	}

}
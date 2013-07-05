<?php

use Carbon\Carbon;
use PayPal\IPN\PPIPNMessage;

class DonationsController extends BaseController {

	/**
	 * Display a list of donations
	 *
	 * @return Response
	 */
	public function index()
	{
		// When did this month start
		$month_start = new Carbon('first day of this month', 'America/Winnipeg');
		$month_start->setTime(0, 0, 0);

		$total_donations = Donation::sum('gross');
		$monthly_total   = Donation::where('created_at', '>=', $month_start)->sum('gross');
		$donations       = Donation::with('donor')->where('created_at', '>=', $month_start)->get();

		// Get the top 10 donors
		$top_donors = DB::table('donors')
			->select(DB::raw('ingame_name, SUM(gross) AS total'))
			->join('donations', 'donors.id', '=', 'donations.donor_id')
			->groupBy('donors.id')
			->orderBy('total', 'desc')
			->take(10)
			->get();

		return View::make('donations.index')
			->with('donations', $donations)
			->with('top_donors', $top_donors)
			->with('monthly_total', $monthly_total)
			->with('total_donations', $total_donations);
	}

	// ------------------------------------------------------------------------

	/**
	 * Recieve an IPN message from PayPal
	 * @return Response
	 */
	public function ipn()
	{
		$data = Input::getContent();

		$config = Config::get('ipn');

		$ipn = new PPIPNMessage($data, $config);

		if ($ipn->validate())
		{
			echo 'VERIFIED';
		}
		else
		{
			echo 'NOT VERIFIED';
		}

		var_dump($data, $ipn);
	}
}
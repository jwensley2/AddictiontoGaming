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
		$monthly_total   = Donation::where('created_at', '>=', $month_start)->where('status', 'Completed')->sum('gross');
		$donations       = Donation::with('donor')->where('created_at', '>=', $month_start)->where('status', 'Completed')->get();

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
		// Setup the IPN object
		$data   = Input::getContent();
		$config = Config::get('paypal');
		$ipn    = new PPIPNMessage($data, $config);

		// Was it a valid message from PayPal?
		if ($ipn->validate())
		{
			// Look for existing donor
			$donor = Donor::where('payer_id', Input::get('payer_id'))->first();

			// Create a new donor
			if ( ! $donor)
			{
				$donor = new Donor;

				$donor->first_name  = Input::get('first_name');
				$donor->last_name   = Input::get('last_name');
				$donor->payer_id    = Input::get('payer_id');
				$donor->steam_id    = Input::get('option_selection1', '');
				$donor->ingame_name = Input::get('option_selection2', '');
				$donor->expires_at  = Carbon::now();

				// Save the donor
				$donor->save();
			}

			// Create the donation
			$donation = new Donation();

			$donation->txn_id = Input::get('txn_id');
			$donation->fee    = Input::get('mc_fee');
			$donation->gross  = Input::get('mc_gross');
			$donation->status = Input::get('payment_status');
			$donation->type   = Input::get('payment_type');

			// Save the donation
			$donor->donations()->save($donation);

			// How many months worth did they donate
			$months = floor($donation->gross / 5);

			$good = array('Completed'); // Good transaction types
			$bad  = array('Refunded', 'Partially_Refunded', 'Reversed'); // Bad transaction types :-(

			if (in_array($donation->status, $good))
			{
				// Add time for good transactions
				$donor->expires_at = $donor->expires_at->addMonths($months);
			}
			elseif (in_array($donation->status, $bad))
			{
				// Remove time for bad transactions
				$donor->expires_at = $donor->expires_at->subMonths($months);
			}

			$donor->save();
		}

		// Log the get data
		Log::info(Input::get(), array('context' => 'PayPal IPN Data'));
	}
}
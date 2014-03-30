<?php

class DonorsController extends BaseController {

	public function getIndex()
	{
		if ( ! Auth::user()->hasPermission('donors_view')) return Redirect::route('admin');

		$donors = Donor::select(DB::raw('donors.*, SUM(gross) as total'))
			->join('donations', 'donors.id', '=', 'donations.donor_id')
			->groupBy('donors.id')
			->orderBy('total', 'desc')
			->paginate(50);

		return View::make('admin.donors.list')
			->with('donors', $donors);
	}

	public function getDonor($id)
	{
		if ( ! Auth::user()->hasPermission('donors_view')) return Redirect::route('admin');

		$donor     = Donor::find($id);
		$donations = $donor->donations()->orderBy('created_at', 'desc')->get();

		return View::make('admin.donors.donor')
			->with('donor', $donor)
			->with('donations', $donations);
	}

}
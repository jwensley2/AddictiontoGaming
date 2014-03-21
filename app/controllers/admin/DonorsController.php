<?php

class DonorsController extends BaseController {

	public function getIndex()
	{
		if ( ! Auth::user()->hasPermission('donors_view')) return Redirect::route('admin');

		$donors = Donor::with('donations')->get();

		$donors->sortBy(function($donor) {
			return $donor->total_donated;
		});

		$donors = $donors->reverse();

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
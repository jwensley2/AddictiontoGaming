<?php

class DonorsController extends BaseController {

	public function getIndex()
	{
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
		$donor     = Donor::find($id);
		$donations = $donor->donations()->orderBy('created_at', 'desc')->get();

		return View::make('admin.donors.donor')
			->with('donor', $donor)
			->with('donations', $donations);
	}

}
<?php

class AdminDonationsController extends BaseController {

	public function getIndex()
	{
		if ( ! Auth::user()->hasPermission('donations_view')) return Redirect::route('admin');

		$donations = Donation::with('donor')
			->orderBy('created_at', 'desc')
			->paginate(100);

		return View::make('admin.donations.list')
			->with('donations', $donations);
	}
}
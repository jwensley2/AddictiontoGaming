<?php

class AdminDonationsController extends BaseController {

	public function getIndex()
	{
		$donations = Donation::with('donor')->orderBy('created_at', 'desc')->get();

		return View::make('admin.donations.list')
			->with('donations', $donations);
	}
}
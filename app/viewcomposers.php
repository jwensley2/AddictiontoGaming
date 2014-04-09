<?php

use ATG\Repositories\Donation\EloquentDonation as Donations;

View::composer('layouts.master', function($view)
{
	$repo = new Donations;

	$donations['goal']    = $repo->monthlyGoal();
	$donations['total']   = $repo->monthlyTotal();
	$donations['percent'] = $repo->monthlyProgress();

	$view->with('donations', $donations);
});
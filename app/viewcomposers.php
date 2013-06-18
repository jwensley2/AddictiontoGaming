<?php

use \Carbon\Carbon;

View::composer('layouts.master', function($view)
{
	$settings = new Settings();

	// Get the monthly cost
	$donations['goal']  = $settings->get('MONTHLY_COST');

	// When did this month start
	$month_start = new Carbon('first day of this month', 'America/Winnipeg');
	$month_start->setTime(0, 0, 0);

	// Get the total donations for the month
	$donations['total'] = Donation::where('created_at', '>=', $month_start)->sum('gross') ?: 0;

	// Calculate the percentage of the goal that has been donated this month
	$donations['percent'] = round(($donations['goal'] / 100) * $donations['total'], 2);

	$view->with('donations', $donations);
});
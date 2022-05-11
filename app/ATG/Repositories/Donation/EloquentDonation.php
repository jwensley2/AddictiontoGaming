<?php

namespace App\ATG\Repositories\Donation;

use Carbon\Carbon;
use App\Models\Settings;
use App\Models\Donation;

class EloquentDonation
{

	public function monthlyGoal()
	{
		return Settings::get('MONTHLY_COST');
	}


	public function monthlyTotal()
	{
		// When did this month start
		$month_start = new Carbon('first day of this month', 'America/Winnipeg');
		$month_start->setTime(0, 0, 0);

		// Get the total donations for the month
		$total = Donation::where('created_at', '>=', $month_start)
			->where('status', 'completed')
			->sum('gross');

		return $total ?: 0;
	}


	public function monthlyProgress()
	{
		$goal  = $this->monthlyGoal();
		$total = $this->monthlyTotal();

		if ($goal AND $total) {
			return min(round((100 / $goal) * $total, 2), 100);
		}

		return 0;
	}
}

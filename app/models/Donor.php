<?php

class Donor extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	/**
	 * Return the date fields to be mutated
	 * http://laravel.com/docs/eloquent#date-mutators
	 * @return array
	 */
	public function getDates()
	{
		return array('created_at', 'updated_at', 'expires_at');
	}

	/**
	 * Get the donations relationship
	 * @return object
	 */
	public function donations()
	{
		return $this->hasMany('Donation');
	}

	/**
	 * Get the donors full name
	 * @return string
	 */
	public function getNameAttribute()
	{
		$this->attributes['name'] = '';

		return "{$this->first_name} {$this->last_name}";
	}

	/**
	 * Calculate the total amount a donor has donated
	 * @return int
	 */
	public function getTotalDonatedAttribute()
	{
		$this->attributes['total_donated'] = '';

		$total = 0;

		foreach ($this->donations AS $donation)
		{
			$total += $donation->gross;
		}

		return number_format($total, 2);
	}
}
<?php

class Donation extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function donor()
	{
		return $this->belongsTo('Donor');
	}
}
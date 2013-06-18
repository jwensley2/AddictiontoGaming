<?php

class Donor extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function donations()
	{
		return $this->hasMany('Donation');
	}
}
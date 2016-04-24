<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
	protected $guarded = [];

	public static $rules = [];

	public function donor()
	{
		return $this->belongsTo('App\Donor');
	}
}
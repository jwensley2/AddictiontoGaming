<?php

namespace App\Models;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
	protected $guarded = [];

	public static $rules = [];

	public function donor()
	{
		return $this->belongsTo(Donor::class);
	}
}

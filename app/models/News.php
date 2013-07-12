<?php

use LaravelBook\Ardent\Ardent;

class News extends Ardent {
	protected $guarded = array();

	public static $rules = array(
		'title'   => 'required|between:5,255',
		'content' => 'required',
	);

	public function user()
	{
		return $this->belongsTo('user');
	}

	public function editor()
	{
		return $this->belongsTo('user', 'edit_user_id');
	}
}
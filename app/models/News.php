<?php

use LaravelBook\Ardent\Ardent;

class News extends Ardent {
	protected $guarded = array();

	public static $rules = array(
		'title'   => 'required|between:5,255',
		'content' => 'required',
	);

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function editor()
	{
		return $this->belongsTo('User', 'edit_user_id');
	}
}
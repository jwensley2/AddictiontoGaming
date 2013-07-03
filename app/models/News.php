<?php

use LaravelBook\Ardent\Ardent;

class News extends Ardent {
	protected $guarded = array();

	public static $rules = array(
		'title'   => 'required|between:10,255',
		'content' => 'required',
	);
}
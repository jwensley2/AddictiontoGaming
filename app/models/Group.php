<?php

use LaravelBook\Ardent\Ardent;

class Group extends Ardent {

	public function users()
	{
		return $this->hasMany('User');
	}

}
<?php

use LaravelBook\Ardent\Ardent;

class Group extends Ardent {

	/**
	 * Return the groups users
	 * @return Relationship
	 */
	public function users()
	{
		return $this->hasMany('User');
	}

	/**
	 * Return the group permissions
	 * @return Relationship
	 */
	public function permissions()
	{
		return $this->belongsToMany('Permission', 'group_permissions')->withPivot('access');
	}
}
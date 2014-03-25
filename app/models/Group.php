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

	/**
	 * Check if group has a permission
	 *
	 * @param type $key The key for the permission
	 * @return bool
	 */
	public function hasPermission($key)
	{

		$hasPermission = $this->permissions()
			->where('key', $key)
			->where('access', 1)
			->first();

		if ($hasPermission) {
			return true;
		}

		return false;
	}
}
<?php

class Permission extends Eloquent {

	public function users()
	{
		return $this->belongsToMany('User', 'user_permissions');
	}

	public function groups()
	{
		return $this->belongsToMany('Group', 'group_permissions');
	}
}
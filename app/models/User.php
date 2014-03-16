<?php

use LaravelBook\Ardent\Ardent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Ardent implements UserInterface, RemindableInterface {
	public static $passwordAttributes = array('password');
	public $autoHashPasswordAttributes = true;
	public $autoPurgeRedundantAttributes = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Validation Rules
	 */
	public static $rules = array(
		'username'         => 'required|alpha_dash|between:3,50',
		'email'            => 'required|email',
		'password'         => 'required|min:6|confirmed',
	);

	/**
	 * Validation rules when creating a new user
	 */
	public static $create_rules = array(
		'username'         => 'required|alpha_dash|between:3,50|unique:users,username',
		'email'            => 'required|email|unique:users,email',
		'password'         => 'required|min:6|confirmed',
	);

	// ------------------------------------------------------------------------

	/**
	 * Return the group relationship
	 * @return Relationship
	 */
	public function group()
	{
		return $this->belongsTo('Group');
	}

	public function permissions()
	{
		return $this->belongsToMany('Permission', 'user_permissions')->withPivot('access');
	}

	public function hasPermission($name)
	{
		$user_access  = 0;
		$group_access = 0;

		// Check if the user has permission
		foreach ($this->permissions AS $permission)
		{
			if ($permission->name === 'founder')
			{
				return 1;
			}

			if ($permission->name == $name)
			{
				$user_access = $permission->pivot->access;
				break;
			}
		}

		// Check if the user's group has permission
		if ($this->group) {
			foreach ($this->group->permissions AS $permission)
			{
				if ($permission->name === 'founder')
				{
					return 1;
				}

				if ($permission->name == $name)
				{
					$group_access = $permission->pivot->access;
					break;
				}
			}
		}

		return (($user_access + $group_access) > 0);
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->username;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
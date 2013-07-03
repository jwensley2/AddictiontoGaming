<?php

use LaravelBook\Ardent\Ardent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Ardent implements UserInterface, RemindableInterface {

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
		'username' => 'required|alpha_dash|between:3,50|unique:users,username',
		'email'    => 'required|email|unique:users,email',
		'password' => 'required|min:6'
	);

	// ------------------------------------------------------------------------

	/**
	 * Run before saving the data
	 * @param  boolean $forced Is it a forced save?
	 * @return bool
	 */
	public function beforeSave($forced = false)
	{
		// if there's a new password, hash it
		if ($this->isDirty('password'))
		{
			$this->password = Hash::make($this->password);
		}

		return true;
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
<?php

class AccountController extends BaseController {

	/**
	 * Login Page
	 */
	public function getLogin()
	{
		return View::make('admin/account/login');
	}


	/**
	 * Process Login
	 */
	public function postLogin($test = true)
	{
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username' => $username, 'password' => $password), true))
		{
			return Redirect::intended('admin');
		}
		else
		{
			return View::make('admin/account/login')
				->with('errors', array('Could not log you in.'));
		}
	}
}